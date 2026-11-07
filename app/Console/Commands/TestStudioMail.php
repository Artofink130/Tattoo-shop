<?php
namespace App\Console\Commands;

use App\Services\StudioMailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TestStudioMail extends Command
{
    protected $signature = 'studio:test-mail {to? : Address to test (defaults to the studio recipient)}';
    protected $description = 'Show the mail configuration and send a real test email, printing the exact error if it fails';

    public function handle(StudioMailer $studio): int
    {
        $this->table(['Setting', 'Value'], [
            ['MAIL_MAILER', config('mail.default')],
            ['SMTP host:port', config('mail.mailers.smtp.host').':'.config('mail.mailers.smtp.port')],
            ['SMTP scheme', config('mail.mailers.smtp.scheme') ?: '(auto: STARTTLS on 587)'],
            ['SMTP username', config('mail.mailers.smtp.username') ? 'set' : 'EMPTY'],
            ['SMTP password', config('mail.mailers.smtp.password') ? 'set' : 'EMPTY'],
            ['From address', config('mail.from.address')],
            ['Studio recipients', implode(', ', $studio->recipients()) ?: 'NONE'],
        ]);

        foreach ($studio->problems() as $problem) $this->warn('! '.$problem);

        $to = $this->argument('to') ?: ($studio->recipients()[0] ?? null);
        if (! $to) { $this->error('No recipient to test. Pass an address: php artisan studio:test-mail you@gmail.com'); return self::FAILURE; }

        try {
            Mail::raw('Test email from '.config('studio.name').". If you can read this, quote emails will reach you.", fn ($m) => $m->to($to)->subject('Studio mail test'));
        } catch (Throwable $e) {
            $this->error('SEND FAILED: '.$e->getMessage());
            $this->line($this->hint($e->getMessage()));
            return self::FAILURE;
        }

        $this->info("Handed to the mail driver for {$to}. Check the inbox AND spam folder.");
        if (in_array(config('mail.default'), ['log', 'array'], true)) $this->warn('Driver is log/array, so nothing was really sent.');

        return self::SUCCESS;
    }

    private function hint(string $m): string
    {
        return match (true) {
            str_contains($m, 'Connection could not be established'), str_contains($m, 'timed out') => 'Hint: wrong MAIL_HOST/MAIL_PORT, or your network/host blocks outgoing SMTP. Port 465 needs MAIL_SCHEME=smtps; 587 uses STARTTLS.',
            str_contains($m, '535'), str_contains($m, 'Authenticat') => 'Hint: wrong MAIL_USERNAME/MAIL_PASSWORD. Gmail needs an App Password (2-step verification on), not your normal password.',
            str_contains($m, 'sender'), str_contains($m, 'from'), str_contains($m, '550'), str_contains($m, '553') => 'Hint: MAIL_FROM_ADDRESS is not allowed by your SMTP provider. Use the SMTP account\'s own address or a verified domain.',
            default => 'Hint: see storage/logs/laravel.log for the full error.',
        };
    }
}
