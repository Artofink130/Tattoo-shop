<?php
use App\Services\CurrencyService;

if (! function_exists('money')) {
    /** Format a USD amount in the visitor's selected currency. */
    function money(float|int|string|null $usd): string
    {
        return app(CurrencyService::class)->format((float) $usd);
    }
}
