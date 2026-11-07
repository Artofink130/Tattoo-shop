<?php
namespace App\Mail;

use App\Models\Quote;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Address, Attachment, Content, Envelope};
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/** Emailed to the studio whenever a visitor submits a quote or consultation request. */
class NewQuoteRequest extends Mailable
{
    use SerializesModels;

    public function __construct(public Quote $quote) {}

    public function envelope(): Envelope
    {
        $type = $this->quote->consultation ? 'consultation' : 'quote';

        return new Envelope(
            subject: "New {$type} request — {$this->quote->name}",
            replyTo: [new Address($this->quote->email, $this->quote->name)], // reply goes straight to the client
        );
    }

    public function content(): Content { return new Content(markdown: 'mail.new-quote'); }

    public function attachments(): array
    {
        $ref = $this->quote->reference;

        return $ref && Storage::disk('public')->exists($ref) ? [Attachment::fromStorageDisk('public', $ref)] : [];
    }
}
