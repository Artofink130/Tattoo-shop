<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function __invoke(string $code, CurrencyService $currency)
    {
        $currency->set(strtoupper($code));
        return back();
    }
}
