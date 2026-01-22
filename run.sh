#!/usr/bin/env bash
set -euo pipefail

if [ -z "${BASH_VERSION:-}" ]; then
  exec bash "$0" "$@"
fi

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT_DIR"

QUEUE_NAME="${QUEUE_NAME:-default}"
QUEUE_WORKERS="${QUEUE_WORKERS:-1}"

pids=()

cleanup() {
  echo "Stopping queue workers..."
  for pid in "${pids[@]:-}"; do
    if kill -0 "$pid" 2>/dev/null; then
      kill -TERM "$pid" 2>/dev/null || true
    fi
  done

  for pid in "${pids[@]:-}"; do
    wait "$pid" 2>/dev/null || true
  done

  echo "Done."
}

trap cleanup INT TERM EXIT

echo "Clearing caches..."
php artisan optimize:clear

echo "Running migrations..."
php artisan migrate

echo "Clearing pending queue jobs..."
if php artisan queue:clear --queue="$QUEUE_NAME" >/dev/null 2>&1; then
  echo "Queue cleared via queue:clear."
elif php artisan queue:flush --queue="$QUEUE_NAME" >/dev/null 2>&1; then
  echo "Queue cleared via queue:flush."
else
  echo "No queue clear/flush command available."
fi

echo "Starting $QUEUE_WORKERS queue worker(s) on '$QUEUE_NAME'..."
for ((i=1; i<=QUEUE_WORKERS; i++)); do
  php artisan queue:work --queue="$QUEUE_NAME" --sleep=1 --tries=1 &
  pid="$!"
  pids+=("$pid")
  echo "Worker $i started (pid $pid)."
done

echo "Starting dev server on http://127.0.0.1:8000 ..."
php artisan serve --host=127.0.0.1 --port=8000
