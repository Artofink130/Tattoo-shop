<?php
namespace Tests\Feature;

use App\Enums\{PaymentStatus, QuoteStatus};
use App\Models\{Payment, Quote, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteFlowTest extends TestCase
{
    use RefreshDatabase;

    private function payload(): array
    {
        return ['name' => 'Ana', 'email' => 'ana@example.com', 'country' => 'Brazil', 'city' => 'São Paulo', 'idea' => 'A lion',
            'style' => 'Realism', 'placement' => 'Forearm', 'size' => '10cm', 'color' => 'Black & Grey'];
    }

    public function test_visitor_can_submit_a_quote_request(): void
    {
        $this->post('/quote', $this->payload())->assertRedirect();
        $this->assertDatabaseHas('quotes', ['email' => 'ana@example.com', 'status' => 'new']);
    }

    public function test_client_payment_then_admin_verification_confirms_booking(): void
    {
        $quote = Quote::create($this->payload() + ['token' => str_repeat('a', 40), 'status' => QuoteStatus::Quoted, 'price' => 400, 'deposit' => 100]);

        $this->post("/quote/{$quote->token}/pay", ['coin' => 'BTC', 'txid' => 'abc123'])->assertRedirect();
        $this->assertSame(QuoteStatus::PaymentSubmitted, $quote->fresh()->status);

        $admin = User::create(['name' => 'A', 'email' => 'a@x.com', 'password' => 'secret-pass', 'is_admin' => true]);
        $payment = Payment::first();
        $this->actingAs($admin)->post("/admin/payments/{$payment->id}/verify")->assertRedirect();

        $this->assertSame(QuoteStatus::Confirmed, $quote->fresh()->status);
        $this->assertSame(PaymentStatus::Verified, $payment->fresh()->status);
    }

    public function test_payment_is_refused_before_a_quote_exists(): void
    {
        $quote = Quote::create($this->payload() + ['token' => str_repeat('b', 40), 'status' => QuoteStatus::New]);
        $this->post("/quote/{$quote->token}/pay", ['coin' => 'BTC', 'txid' => 'zzz'])->assertForbidden();
    }

    public function test_pricing_a_request_defaults_the_deposit_to_fifty_percent(): void
    {
        $quote = Quote::create($this->payload() + ['token' => str_repeat('c', 40), 'status' => QuoteStatus::New]);
        $admin = User::create(['name' => 'A', 'email' => 'a@x.com', 'password' => 'secret-pass', 'is_admin' => true]);

        $this->actingAs($admin)->put("/admin/quotes/{$quote->id}", ['status' => 'new', 'price' => 400])->assertRedirect();

        $this->assertSame(QuoteStatus::Quoted, $quote->fresh()->status);
        $this->assertEquals(200, $quote->fresh()->deposit);
    }
}
