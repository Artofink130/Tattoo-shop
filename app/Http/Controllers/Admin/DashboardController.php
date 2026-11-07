<?php
namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\{Payment, Quote};
use App\Support\MailHealth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'counts' => Quote::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status'),
            'revenue' => Payment::where('status', PaymentStatus::Verified)->sum('amount_usd'),
            'pending' => Payment::with('quote')->where('status', PaymentStatus::Pending)->latest()->get(),
            'recent' => Quote::with('artist')->latest()->take(8)->get(),
            'undelivered' => Quote::whereNull('studio_notified_at')->whereNotNull('mail_error')->latest()->take(5)->get(),
            'mailWarning' => MailHealth::problem(),
        ]);
    }
}
