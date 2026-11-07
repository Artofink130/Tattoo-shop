<?php
namespace App\Services;

use App\Enums\{Coin, PaymentStatus, QuoteStatus};
use App\Models\{Payment, Quote};
use App\Notifications\QuoteUpdate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{DB, Notification};
use Illuminate\Support\Str;

/** Domain logic for the quote → payment → booking lifecycle. */
class QuoteService
{
    public function create(array $data, ?UploadedFile $reference = null): Quote
    {
        if ($reference) $data['reference'] = $reference->store('references', 'public');

        $quote = Quote::create($data + ['token' => Str::random(40), 'status' => QuoteStatus::New]);
        $this->notify($quote, 'We received your request', 'Thank you! Our team will review your project and send your quote soon.');

        return $quote;
    }

    public function update(Quote $quote, array $data): Quote
    {
        $previous = $quote->status;
        if ($previous === QuoteStatus::New && $data['status'] === 'new' && ! empty($data['price'])) {
            $data['status'] = QuoteStatus::Quoted->value; // pricing a new request implies quoting it
        }
        if (! empty($data['price']) && empty($data['deposit'])) {
            $data['deposit'] = round($data['price'] * config('studio.deposit_percent') / 100, 2); // default deposit
        }
        $quote->update($data);

        if ($previous !== $quote->status) {
            match ($quote->status) {
                QuoteStatus::Quoted => $this->notify($quote, 'Your quote is ready', 'Your quote and deposit details are ready to review.'),
                QuoteStatus::Confirmed => $this->notify($quote, 'Your booking is confirmed', 'Your deposit was verified. Your artist will contact you with session details.'),
                default => null,
            };
        }
        return $quote;
    }

    public function submitPayment(Quote $quote, Coin $coin, string $txid): Payment
    {
        return DB::transaction(function () use ($quote, $coin, $txid) {
            $payment = $quote->payments()->create([
                'coin' => $coin, 'txid' => $txid, 'amount_usd' => $quote->deposit, 'status' => PaymentStatus::Pending,
            ]);
            $quote->update(['status' => QuoteStatus::PaymentSubmitted]);
            return $payment;
        });
    }

    public function verifyPayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $payment->update(['status' => PaymentStatus::Verified, 'verified_at' => now()]);
            $this->update($payment->quote, ['status' => QuoteStatus::Confirmed->value]);
        });
    }

    public function rejectPayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $payment->update(['status' => PaymentStatus::Rejected]);
            $payment->quote->update(['status' => QuoteStatus::Quoted]); // lets the client resubmit
        });
    }

    private function notify(Quote $quote, string $subject, string $line): void
    {
        Notification::route('mail', $quote->email)->notify(new QuoteUpdate($subject, $line, $quote));
    }
}
