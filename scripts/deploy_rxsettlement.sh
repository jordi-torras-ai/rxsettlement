#!/bin/bash
set -euo pipefail

# --- Config ---
APP_DIR="/var/www/app.torras.ai/rxsettlement"
APP_USER="www-data"
BRANCH="main"

# --- Helpers ---
require_root() {
  if [[ "$(id -u)" -ne 0 ]]; then
    echo "This script must be run as root (use sudo)."
    exit 1
  fi
}

need_cmd() {
  command -v "$1" >/dev/null 2>&1 || { echo "Missing required command: $1"; exit 1; }
}

as_app() {
  sudo -u "$APP_USER" -H bash -lc "$*"
}

# --- Start ---
require_root
need_cmd git
need_cmd composer
need_cmd systemctl
need_cmd php

if [[ ! -d "$APP_DIR" ]]; then
  echo "App directory not found: $APP_DIR"
  exit 1
fi

echo "--------------------------------------------"
echo "📂 Deploying rxsettlement (branch: $BRANCH)"
echo "Running as root; app commands will run as: $APP_USER"
cd "$APP_DIR"

# Ensure key paths are owned by www-data (minimal set)
chown -R "$APP_USER:$APP_USER" "$APP_DIR/.git" 2>/dev/null || true
chown -R "$APP_USER:$APP_USER" "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" || true

# Ensure storage/cache dirs exist
mkdir -p "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
chown -R "$APP_USER:$APP_USER" "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" || true

# Reasonable perms for Laravel writable dirs
find "$APP_DIR/storage" -type d -exec chmod 775 {} \; || true
find "$APP_DIR/bootstrap/cache" -type d -exec chmod 775 {} \; || true

# Make sure www-data has a usable HOME and known_hosts (avoids fetch prompts)
if [[ ! -d /var/www/.ssh ]]; then
  mkdir -p /var/www/.ssh
  chown "$APP_USER:$APP_USER" /var/www/.ssh
  chmod 700 /var/www/.ssh
fi
if [[ ! -f /var/www/.ssh/known_hosts ]] || ! grep -q 'github.com' /var/www/.ssh/known_hosts; then
  as_app "ssh-keyscan -H github.com >> /var/www/.ssh/known_hosts"
  chmod 600 /var/www/.ssh/known_hosts
  chown "$APP_USER:$APP_USER" /var/www/.ssh/known_hosts
fi

echo "--------------------------------------------"
echo "🔍 Reading current version from .env ..."
CURR_VER=""
if [[ -f ".env" ]]; then
  CURR_VER="$(grep -E '^APP_VERSION=' .env | cut -d '=' -f2- || true)"
fi
echo "Current version: ${CURR_VER:-not set}"
read -rp "Enter new version (or press Enter to keep ${CURR_VER:-'(unset)'}): " NEW_VER
NEW_VER="${NEW_VER:-$CURR_VER}"

if [[ -n "${NEW_VER:-}" && -f ".env" ]]; then
  chown "$APP_USER:$APP_USER" .env 2>/dev/null || true
  if grep -q '^APP_VERSION=' .env; then
    as_app "sed -i 's/^APP_VERSION=.*/APP_VERSION=${NEW_VER}/' .env"
  else
    as_app "printf '\nAPP_VERSION=${NEW_VER}\n' >> .env"
  fi
fi

echo "--------------------------------------------"
echo "⬇️  Pulling latest code from Git ..."
as_app "git config --local safe.directory '$APP_DIR' || true"
as_app "git fetch --all"
as_app "git checkout '$BRANCH'"
as_app "git pull origin '$BRANCH'"

echo "--------------------------------------------"
if [[ -f "composer.json" ]]; then
  echo "📦 Installing Composer dependencies (no-dev, optimized) ..."
  as_app "composer install --no-dev --optimize-autoloader"
fi

# If you have a frontend build in CI and commit /public/build, you can skip npm here.
# Otherwise, consider adding:
# need_cmd npm
# as_app "npm ci && npm run build"

echo "--------------------------------------------"
if [[ -f "artisan" ]]; then
  echo "🧱 Running migrations & optimizing caches ..."
  as_app "php artisan migrate --force"

  # Safe to re-run, creates public/storage symlink if needed
  as_app "php artisan storage:link || true"

  # Clear + rebuild caches
  as_app "php artisan optimize:clear"
  as_app "php artisan optimize"

  echo "🔁 Restarting queues (if used) ..."
  as_app "php artisan queue:restart || true"
fi

echo "--------------------------------------------"
echo "🌐 Reloading Apache ..."
systemctl reload apache2 || systemctl restart apache2

echo "--------------------------------------------"
echo "✅ rxsettlement deployment complete!"
[[ -n "${NEW_VER:-}" ]] && echo "Version deployed: $NEW_VER"
