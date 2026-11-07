# Email delivery for quotes & consultations

Every quote or consultation request is now emailed to the studio (reply-to = the client, reference image attached, "Open in admin" button). The client still gets their own confirmation email, and a mail failure never blocks the visitor.

## Apply
Unzip over your project (same folder structure).
- **New:** `app/Mail/NewQuoteRequest.php`, `resources/views/mail/new-quote.blade.php`, `tests/Feature/QuoteEmailTest.php`
- **Modified:** `app/Services/QuoteService.php` (new `alertStudio()`, mail failures caught), `config/studio.php` (adds `notify_email`; if you edited prices/wallet defaults there, re-apply the one line instead of overwriting: `'notify_email' => env('STUDIO_NOTIFY_EMAIL', env('ADMIN_EMAIL')),`)

## Configure `.env` (add these lines)
```
STUDIO_NOTIFY_EMAIL=studio@yourdomain.com
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-user
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=studio@yourdomain.com
```
Then run `php artisan config:clear`.

## Test locally
With `MAIL_MAILER=log` (the default) the email is written to `storage/logs/laravel.log`. For a real inbox view use Mailpit (`MAIL_MAILER=smtp`, `MAIL_HOST=127.0.0.1`, `MAIL_PORT=1025`). Run the tests with `composer test`.
