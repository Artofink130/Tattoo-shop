<?php
namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteUpdate extends Notification
{
    public function __construct(private string $subject, private string $line, private Quote $quote) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject($this->subject)->greeting("Hi {$this->quote->name},")
            ->line($this->line)->action('View your quote', route('quote.show', $this->quote->token));
    }
}
