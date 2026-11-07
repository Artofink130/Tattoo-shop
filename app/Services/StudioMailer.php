<?php
namespace App\Services;

use App\Mail\NewQuoteRequest;
use App\Models\{Quote, User};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

/** Sends the "new request" email to the studio and records whether it really went out. */
class StudioMailer
{
    /** Valid, non-placeholder recipients: STUDIO_NOTIFY_EMAIL (comma-separated), else every admin user's email. */
    public function recipients(): array
    {
        $configured = $this->clean(explode(',', (string) config('studio.notify_email')));

        return $configured ?: $this->clean(User::where('is_admin', true)->pluck('email')->all());
    }

    /** Human-readable configuration problems that would stop the owner from receiving email. */
    public function problems(): array
    {
        $problems = [];
        $mailer = config('mail.default');

        if (in_array($mailer, ['log', 'array'], true)) {
            $problems[] = "MAIL_MAILER is '{$mailer}': emails are NOT delivered, they are only written to storage/logs/laravel.log. Set MAIL_MAILER=smtp and your SMTP credentials.";
        }
        if (str_ends_with(strtolower((string) config('mail.from.address')), '@example.com')) {
            $problems[] = 'MAIL_FROM_ADDRESS is a placeholder (@example.com); SMTP providers reject or drop it. Use an address your SMTP account is allowed to send from.';
        }
        if (! $this->recipients()) {
            $problems[] = 'No valid recipient: set STUDIO_NOTIFY_EMAIL to the owner\'s real address (placeholders at example.com are ignored) or give an admin user a real email.';
        }

        return $problems;
    }

    public function send(Quote $quote): bool
    {
        if (! $to = $this->recipients()) {
            return $this->fail($quote, implode(' ', $this->problems()));
        }

        try {
            Mail::to($to)->send(new NewQuoteRequest($quote));
        } catch (Throwable $e) {
            report($e);
            return $this->fail($quote, Str::limit($e->getMessage(), 500));
        }

        if (in_array(config('mail.default'), ['log', 'array'], true)) {
            return $this->fail($quote, $this->problems()[0]);
        }

        $quote->update(['studio_notified_at' => now(), 'mail_error' => null]);

        return true;
    }

    private function fail(Quote $quote, string $reason): bool
    {
        $quote->update(['studio_notified_at' => null, 'mail_error' => $reason]);

        return false;
    }

    private function clean(array $emails): array
    {
        return collect($emails)->map(fn ($e) => trim((string) $e))
            ->filter(fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL) && ! str_ends_with(strtolower($e), '@example.com'))
            ->unique()->values()->all();
    }
}
