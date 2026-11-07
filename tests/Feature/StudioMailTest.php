<?php
namespace Tests\Feature;

use App\Mail\NewQuoteRequest;
use App\Models\{Quote, User};
use App\Services\StudioMailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Mail, Notification};
use Tests\TestCase;

class StudioMailTest extends TestCase
{
    use RefreshDatabase;

    private function payload(): array
    {
        return ['name' => 'Ana', 'email' => 'ana@client.com', 'country' => 'Brazil', 'city' => 'São Paulo', 'idea' => 'A lion',
            'style' => 'Realism', 'placement' => 'Forearm', 'size' => '10cm', 'color' => 'Black & Grey'];
    }

    public function test_placeholder_recipients_are_ignored_and_admin_emails_are_used(): void
    {
        config(['studio.notify_email' => 'studio@example.com']);
        User::create(['name' => 'Owner', 'email' => 'owner@mystudio.com', 'password' => 'secret-pass', 'is_admin' => true]);

        $this->assertSame(['owner@mystudio.com'], app(StudioMailer::class)->recipients());
    }

    public function test_successful_delivery_is_recorded(): void
    {
        Mail::fake(); Notification::fake();
        config(['studio.notify_email' => 'owner@mystudio.com', 'mail.default' => 'smtp']);

        $this->post('/quote', $this->payload())->assertRedirect();

        Mail::assertSent(NewQuoteRequest::class);
        $this->assertNotNull(Quote::first()->studio_notified_at);
        $this->assertNull(Quote::first()->mail_error);
    }

    public function test_missing_recipient_is_recorded_instead_of_hidden(): void
    {
        Mail::fake(); Notification::fake();
        config(['studio.notify_email' => 'studio@example.com', 'mail.default' => 'smtp']);

        $this->post('/quote', $this->payload())->assertRedirect();

        Mail::assertNothingSent();
        $this->assertStringContainsString('recipient', Quote::first()->mail_error);
    }

    public function test_admin_can_resend_a_failed_email(): void
    {
        Mail::fake(); Notification::fake();
        config(['studio.notify_email' => 'studio@example.com', 'mail.default' => 'smtp']);
        $this->post('/quote', $this->payload());

        config(['studio.notify_email' => 'owner@mystudio.com']);
        $admin = User::create(['name' => 'A', 'email' => 'a@mystudio.com', 'password' => 'secret-pass', 'is_admin' => true]);
        $this->actingAs($admin)->post('/admin/quotes/'.Quote::first()->id.'/resend')->assertRedirect();

        Mail::assertSent(NewQuoteRequest::class);
        $this->assertNotNull(Quote::first()->studio_notified_at);
    }
}
