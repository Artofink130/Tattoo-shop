<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function __invoke() { return view('site.pricing', ['prices' => config('studio.prices')]); }
}
