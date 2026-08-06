# Sadlers Taxis — website & CMS

A Laravel + Filament rebuild of sadlerstaxis.co.uk. Every page (Home, About, Services, Accounts,
Careers, Contact, Privacy Policy) and every form (Contact, New Business Account Application,
Driver Application) is editable from a single admin dashboard at `/admin`.

Runs on standard PHP hosting — no Node.js server required in production (Node/npm is only used
locally to build the CSS once).

## Local development

Requirements: PHP 8.4+, Composer.

```bash
composer install
npm install && npm run build   # builds resources/css/app.css into public/build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed     # creates the DB schema and fills every page with real content
php artisan storage:link       # makes uploaded images (logo, hero image, etc.) publicly accessible
php artisan serve
```

The seed command prints your first admin login (email + password) in the terminal — log in at
`/admin` and change the password afterwards.

Visit:
- `http://localhost:8000` — the public site
- `http://localhost:8000/admin` — the CMS

## What's editable in the CMS

- **Settings → Site Settings** — phone numbers per area, primary phone, email, external links
  (online booking, corporate booking, iOS/Android app links), the marshal warning banner.
- **Pages → Home / About / Services / Careers / Accounts / Contact / Privacy Policy** — each is
  its own screen with plain-language fields (headings, rich text, image uploads, repeatable
  cards).
- **Forms** — the Contact form, the New Business Account Application form, and the Driver
  Application form all live here. Fields can be renamed, reordered (drag handles), marked
  required/optional, or added to, and the notification email address/subject/message can be
  changed — no code changes needed.
- **Form Submissions** — every submission is stored here as a backup, in addition to being
  emailed out.

## Environment variables

Key settings in `.env`:

- `DATABASE_URL` isn't used — SQLite is configured via `DB_CONNECTION=sqlite`, storing everything
  in `database/database.sqlite`. No external database server required (works on MySQL too if your
  host prefers it — just change the `DB_*` values and re-run migrations).
- `MAIL_MAILER` — set to `log` locally (emails are written to `storage/logs/laravel.log` instead
  of sent, so nothing breaks without real credentials). For production, set this to `smtp` and
  fill in `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD` with your mailbox provider's
  details (e.g. Microsoft 365, Google Workspace, or your host's mail server).
- `APP_URL` — the site's public URL in production.

## Deployment (cPanel / standard PHP hosting)

This is a standard Laravel app — it runs on any host that supports PHP 8.2+ and Composer,
including ordinary cPanel/shared hosting. No Node.js server is needed at runtime.

1. Upload the project (excluding `node_modules` and `vendor` — reinstall those on the server).
2. On the server: `composer install --no-dev --optimize-autoloader`.
3. Build the frontend assets **before** upload (locally: `npm install && npm run build`) and
   upload the resulting `public/build` folder — or build on the server if it has Node available.
4. Point your domain's document root at this project's `public/` folder (cPanel usually has a
   "Domains" setting for this, or use a symlink if you can't change the document root).
5. Copy `.env.example` to `.env`, fill in production values, then run:
   ```bash
   php artisan key:generate
   php artisan migrate --seed   # first deploy only
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   ```
6. Set real SMTP credentials in `.env` so form notification emails actually send.
7. Back up `database/database.sqlite` regularly (or switch to MySQL if your host provides it —
   just update `DB_CONNECTION` and the `DB_*` values, then re-run migrations).

## Project structure

- `app/Http/Controllers/PageController.php` — the 7 public page routes.
- `app/Http/Controllers/FormSubmissionController.php` — handles all form POSTs, validation, and
  email notifications.
- `app/Models` — `SiteSetting` and one model per page (`HomePage`, `AboutPage`, etc.), each a
  single-row "singleton" table, plus `Form` and `FormSubmission`.
- `app/Filament/Pages` — the CMS screens for each singleton page/settings model.
- `app/Filament/Resources` — the CMS screens for `Forms` and `Form Submissions`.
- `resources/views/pages` — the public Blade templates.
- `resources/views/components` — shared UI: `layout`, `header`, `footer`, `rich-text`,
  `dynamic-form` (renders whatever fields a Form record defines).
- `database/seeders/SadlersTaxisSeeder.php` — the one-time content seed (`php artisan db:seed`).
