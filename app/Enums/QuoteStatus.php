<?php
namespace App\Enums;

enum QuoteStatus: string
{
    case New = 'new';
    case Quoted = 'quoted';
    case PaymentSubmitted = 'payment_submitted';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    public function label(): string { return ucfirst(str_replace('_', ' ', $this->value)); }

    public function color(): string
    {
        return match ($this) {
            self::New => 'bg-sky-900 text-sky-200',
            self::Quoted => 'bg-amber-900 text-amber-200',
            self::PaymentSubmitted => 'bg-purple-900 text-purple-200',
            self::Confirmed => 'bg-emerald-900 text-emerald-200',
            self::Cancelled => 'bg-neutral-800 text-neutral-400',
        };
    }
}
