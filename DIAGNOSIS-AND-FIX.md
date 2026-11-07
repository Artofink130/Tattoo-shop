# Why the owner received no quote email — diagnosis & fix

## What went wrong
I can't see your `.env` or logs, so I can't name the single cause, but the first version had **three weak spots** that each produce exactly this symptom (visitor sees success, nobody gets an email):

1. **Mail was probably never really sent.** The default `MAIL_MAILER=log` only writes the email into `storage/logs/laravel.log`. Until SMTP is configured, nothing reaches an inbox.
2. **Placeholder recipient.** `STUDIO_NOTIFY_EMAIL` defaulted to `studio@example.com`, falling back to `admin@example.com`. Those addresses don't exist, so the mail goes nowhere.
3. **Failures were silent.** I wrapped sending in a try/catch that only logged the error, so a wrong password, blocked port or rejected From address looked like success.

Common real-SMTP causes: wrong credentials (Gmail needs an *App Password*), `MAIL_FROM_ADDRESS` not allowed by the provider, blocked port, port 465 without `MAIL_SCHEME=smtps`, a cached config, or the message sitting in spam.
(Note: Laravel 12 ignores `MAIL_ENCRYPTION`; STARTTLS on port 587 is automatic.)

## What this update does
- **`php artisan studio:test-mail you@gmail.com`** prints your mail settings, warns about each problem, sends a real test email and prints the exact error plus a hint. **Run this first — it tells you the cause.**
- **Placeholder addresses (`@example.com`) are ignored.** If `STUDIO_NOTIFY_EMAIL` is missing or fake, the email goes to every admin user's real address. `STUDIO_NOTIFY_EMAIL` may hold several addresses, comma-separated.
- **Nothing is hidden anymore:** every request records whether the studio email was sent. Admin shows a red banner on the dashboard for undelivered requests, a ✓/✗ status on each request, and a **Resend email** button.
- Mail template made safer for multi-line ideas.

## Apply
1. Unzip over the project (same paths). Overwrites: `QuoteService`, `Quote` model, admin `DashboardController`, `routes/admin.php`, `bootstrap/app.php`, two admin views, the mail view, and `QuoteEmailTest`.
2. `php artisan migrate` (adds two columns to `quotes`).
3. Set `.env` (real values):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com        # or your provider's SMTP host
MAIL_PORT=587
MAIL_USERNAME=youraddress@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=youraddress@gmail.com   # must be allowed by your SMTP account
MAIL_FROM_NAME="Ink Legacy Tattoo Studio"
STUDIO_NOTIFY_EMAIL=owner@yourdomain.com
```
4. `php artisan config:clear`, restart `php artisan serve`, then run `php artisan studio:test-mail you@gmail.com`.
5. Send a quote from the site and check the inbox **and spam**. `composer test` runs the tests.
