<?php
namespace App\Enums;

enum Coin: string
{
    case BTC = 'BTC';
    case ETH = 'ETH';
    case USDT = 'USDT';

    public function network(): string
    {
        return match ($this) {
            self::BTC => 'Bitcoin network',
            self::ETH => 'Ethereum (ERC-20)',
            self::USDT => 'TRON (TRC-20)',
        };
    }

    public function address(): string { return (string) config('studio.wallets.'.$this->value); }
}
