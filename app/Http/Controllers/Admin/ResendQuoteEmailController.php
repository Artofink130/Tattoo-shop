<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Services\StudioMailer;

class ResendQuoteEmailController extends Controller
{
    public function __invoke(Quote $quote, StudioMailer $mailer)
    {
        if ($mailer->send($quote)) {
            return back()->with('ok', 'Email sent to '.implode(', ', $mailer->recipients()).'.');
        }

        return back()->withErrors(['mail' => $quote->fresh()->mail_error ?: 'The email could not be sent.']);
    }
}
