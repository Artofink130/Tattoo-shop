<?php
namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\QuoteService;

class PaymentController extends Controller
{
    public function __construct(private QuoteService $quotes) {}

    public function verify(Payment $payment)
    {
        abort_unless($payment->status === PaymentStatus::Pending, 422);
        $this->quotes->verifyPayment($payment);
        return back()->with('ok', 'Payment verified and booking confirmed.');
    }

    public function reject(Payment $payment)
    {
        abort_unless($payment->status === PaymentStatus::Pending, 422);
        $this->quotes->rejectPayment($payment);
        return back()->with('ok', 'Payment rejected; the client can resubmit.');
    }
}
