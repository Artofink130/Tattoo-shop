<?php
use App\Http\Controllers\Admin\
{ArtistController, AuthController, DashboardController, PaymentController, QuoteController, ResendQuoteEmailController};
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->middleware('throttle:5,1');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('quotes', QuoteController::class)->only(['index', 'show', 'update']);
        Route::post('quotes/{quote}/resend', ResendQuoteEmailController::class)->name('quotes.resend');
        Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
        Route::resource('artists', ArtistController::class)->except(['create', 'show']);
    });
});
