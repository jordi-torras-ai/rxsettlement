# RX Settlement

RX Settlement is a Laravel 12 + Filament 3 application for managing employers, intakes, vendor coverages, plan design years, documents, and reference tables.

## Requirements

- PHP 8.2+
- Composer
- Node.js / npm
- Postgres

## Quick start

1. Install dependencies:

```bash
composer install
npm install
```

2. Configure environment:

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your Postgres credentials.

If using Cloudflare R2 for document storage, add:

```bash
FILESYSTEM_DISK=r2
R2_ACCESS_KEY_ID=...
R2_SECRET_ACCESS_KEY=...
R2_BUCKET=...
R2_ENDPOINT=https://<account_id>.r2.cloudflarestorage.com
R2_PUBLIC_URL=
```

3. Run the app:

```bash
./run.sh
```

This will clear caches, run migrations, reset pending queue jobs, start queue workers in the background, and run the dev server at `http://127.0.0.1:8000`.

## Admin panel

- URL: `http://127.0.0.1:8000/admin`
- Admins are users with `user_type = 'admin'`.
- The `user_type` migration attempts to set `jordi@torras.ai` as admin (if that user exists).

## Notes

- Employers are visible to all users; non-admins can only see/edit their own employer and cannot edit the legal name.
- Intakes, Vendor Coverages, and Plan Design Years are scoped to the current user for non-admins.
- Audit Trail is available to admins under the Admin menu group.
- Glossary is read-only and populated via a seeder; it supports filtering by type.
- Document Types is an admin-only CRUD table (Admin menu).
- Documents are available to all users, scoped by intake; uploads go to R2.
- Documents list includes a "Required Documents" action to generate empty placeholders per intake.

## Useful env vars

- `QUEUE_NAME` (default: `default`)
- `QUEUE_WORKERS` (default: `1`)

## Utilities

- `scripts/r2_test.php` writes a small file to R2 and checks its size/existence.

## Tests

```bash
php artisan test
```
