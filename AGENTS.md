# Agent Notes

## Project overview

- Laravel 12 + Filament 3 app.
- Admin panel at `/admin`.
- `run.sh` clears caches, migrates, resets queues, starts workers, and serves the app.

## Conventions

- Use new migrations for schema changes; do not edit old migrations.
- Avoid editing `vendor/` or `storage/` unless explicitly requested.
- Keep Filament resources scoped:
  - Admins see all records.
  - Non-admins only see their own records (or their employer).
- Employer legal name is read-only for non-admins.

## Filament UX

- Table actions are icon-only (View/Edit/Delete when allowed).
- Create/Edit pages redirect back to the list using `app/Filament/Pages/Concerns/RedirectToIndex.php`.

## Role rules

- Admins are users with `user_type = 'admin'`.
- Audit Trail is admin-only and lives under the Admin menu group.

## Data relationships

- Users belong to Employers (nullable).
- Intakes belong to Users.
- Vendor Coverages belong to Intakes and Users.
- Plan Design Years belong to Intakes and Users and have inline detail tables:
  - Budget Premium-Equivalent Funding Monthly Rates
  - Employee Monthly Contributions
  - PEPM Admin Fee Group
