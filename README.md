# RX Settlement

RX Settlement is a Laravel 12 + Filament 3 application for managing employers, intakes, vendor coverages, and plan design years.

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

## Useful env vars

- `QUEUE_NAME` (default: `default`)
- `QUEUE_WORKERS` (default: `1`)

## Tests

```bash
php artisan test
```
