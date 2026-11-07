<?php
namespace Tests\Feature;

use App\Mail\NewQuoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Mail, Notification};
use Tests\TestCase;

class QuoteEmailTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $extra = []): array
    {
        return $extra + ['name' => 'Ana', 'email' => 'ana@example.com', 'country' => 'Brazil', 'city' => 'São Paulo', 'idea' => 'A lion',
            'style' => 'Realism', 'placement' => 'Forearm', 'size' => '10cm', 'color' => 'Black & Grey'];
    }

    private function configure(): void
    {
        Mail::fake(); Notification::fake();
        config(['studio.notify_email' => 'studio@mystudio.com', 'mail.default' => 'smtp']);
    }

    public function test_studio_is_emailed_when_a_quote_is_requested(): void
    {
        $this->configure();
        $this->post('/quote', $this->payload())->assertRedirect();

        Mail::assertSent(NewQuoteRequest::class, fn ($m) => $m->hasTo('studio@mystudio.com') && $m->hasReplyTo('ana@example.com') && ! $m->quote->consultation);
    }

    public function test_studio_is_emailed_when_a_consultation_is_booked(): void
    {
        $this->configure();
        $this->post('/quote', $this->payload(['consultation' => 1]))->assertRedirect();

        Mail::assertSent(NewQuoteRequest::class, fn ($m) => $m->quote->consultation);
    }
}
