<<<<<<< HEAD
# Ink Legacy Tattoo Studio — Booking Platform (Laravel 12)

Public website + separate admin back-office for a multi-artist tattoo studio serving Brazil, Argentina and the US.
Visitors request quotes/consultations, switch USD/BRL/ARS, and pay deposits in **crypto**; admins price requests, assign artists and verify on-chain payments.

## Architecture
```
app/
  Enums/          QuoteStatus, PaymentStatus, Coin
  Models/         User, Artist, Quote, Payment
  Services/       QuoteService (quote → payment → booking lifecycle), CurrencyService
  Notifications/  QuoteUpdate (client emails)
  Http/
    Controllers/Site/   Home, Artist, Pricing, Currency, Quote
    Controllers/Admin/  Auth, Dashboard, Quote, Payment, Artist
    Requests/           validation per action (FormRequests)
    Middleware/         AdminOnly, SecurityHeaders
routes/web.php (public) · routes/admin.php (admin, auth + admin middleware)
resources/views/        layouts/, components/ (field, choice, badge, artist-card), site/, admin/
config/studio.php       prices, styles, currency rates, wallet addresses
tests/Feature/          quote/payment flow + admin access tests
```
Visitors never need accounts: each quote has a private unguessable link. Admin accounts are `users.is_admin = true`; admin routes sit behind `auth` + `admin` middleware and a rate-limited login.

## 1. Install first
- **PHP 8.2+** with `mbstring`, `openssl`, `pdo_sqlite` (or `pdo_mysql`), `fileinfo`, `curl`, `xml/dom`, `zip`, `ctype`, `tokenizer`
- **Composer 2** — https://getcomposer.org
- Optional: MySQL 8/MariaDB (production), Git. **Node.js is not required** (Tailwind via CDN).
- Windows: Laragon or XAMPP (PHP 8.2+) + Composer is easiest.

## 2. Run locally
```bash
cd inkwell-studio
composer install
cp .env.example .env              # Windows: copy .env.example .env
php artisan key:generate
touch database/database.sqlite    # Windows: type nul > database\database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
composer test                     # optional: run the test suite
```
Site: http://localhost:8000 · Admin: http://localhost:8000/admin/login (`ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env` — change them before seeding).

## 3. Configure
- **Crypto addresses:** `.env` → `WALLET_BTC`, `WALLET_ETH`, `WALLET_USDT` (TRC-20).
- **Currency rates:** `RATE_BRL`, `RATE_ARS` (update periodically).
- **Prices & styles:** `config/studio.php`. **Artists:** admin → Artists.
- **Email:** `MAIL_*` in `.env` (defaults to `log`, i.e. written to `storage/logs`). Use SMTP in production.

## Content & business rules
- Studio name: `STUDIO_NAME` in `.env`. Premium menu prices, placement guide and styles: `config/studio.php`.
- Deposit: `DEPOSIT_PERCENT` (default **50%** of the quoted price). Leave the deposit empty when pricing a request and it is filled in automatically.
- Gallery: drop your own photos into `public/gallery/` and they appear on the home page. Only use photos you own or have permission to publish.
- Quote requests include an optional client budget, shown to admins.

## 4. Payment flow
1. Client submits request → status *New* (email sent). 2. Admin sets price + deposit → *Quoted* (email sent).
3. Client sends crypto to your address and submits the tx hash → *Payment submitted*.
4. Admin checks the transaction on a block explorer → **Verify** (booking *Confirmed*, email sent) or **Reject** (client may resubmit).
Verification is deliberately manual; there is no gateway or webhook.

## 5. Deploy (Ubuntu VPS + Nginx)
1. Install PHP 8.2-fpm + extensions, Nginx, MySQL, Composer; upload to `/var/www/inkwell`.
2. `composer install --no-dev --optimize-autoloader`; `cp .env.example .env`; set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://yourdomain`, `DB_*` (MySQL), SMTP, strong admin password, wallets.
3. `php artisan key:generate && php artisan migrate --force --seed && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. `chown -R www-data:www-data storage bootstrap/cache`
5. Nginx root `/var/www/inkwell/public`, `try_files $uri $uri/ /index.php?$query_string;`, `.php` → php-fpm; enable HTTPS with `certbot --nginx`.
Shared hosting: point the document root at `public/`.

## Not yet included
Per-artist portfolio galleries, automatic on-chain verification, a Vite-built CSS bundle (replace the Tailwind CDN tag in `resources/views/layouts/*.blade.php` for heavy traffic), multi-language UI, and calendar/availability booking. Check tattoo-business and crypto regulations in each country you serve.
=======
# Tattoo-shop
>>>>>>> 
