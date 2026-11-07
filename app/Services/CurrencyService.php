<?php
namespace App\Services;

class CurrencyService
{
    private const SYMBOLS = ['USD' => '$', 'BRL' => 'R$', 'ARS' => 'ARS '];

    public function supported(): array { return array_keys(config('studio.rates')); }

    public function current(): string
    {
        $c = session('currency', 'USD');
        return in_array($c, $this->supported(), true) ? $c : 'USD';
    }

    public function set(string $code): void
    {
        if (in_array($code, $this->supported(), true)) session(['currency' => $code]);
    }

    public function format(float $usd): string
    {
        $c = $this->current();
        return self::SYMBOLS[$c].number_format($usd * config("studio.rates.$c", 1), 0, '.', ',');
    }
}
