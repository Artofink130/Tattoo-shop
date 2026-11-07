<?php
use App\Http\Controllers\Site\
{ArtistController, CurrencyController, HomeController, PricingController, QuoteController};
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/artists', [ArtistController::class, 'index'])->name('artists');
Route::get('/pricing', PricingController::class)->name('pricing');
Route::get('/currency/{code}', CurrencyController::class)->name('currency');

Route::prefix('quote')->name('quote.')->controller(QuoteController::class)->group(function () {
    Route::get('/', 'create')->name('create');
    Route::post('/', 'store')->middleware('throttle:6,1')->name('store');
    Route::get('/{quote:token}', 'show')->name('show');
    Route::post('/{quote:token}/pay', 'pay')->middleware('throttle:10,1')->name('pay');
});
