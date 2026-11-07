<?php
namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';

    public function label(): string { return ucfirst($this->value); }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-900 text-amber-200',
            self::Verified => 'bg-emerald-900 text-emerald-200',
            self::Rejected => 'bg-red-900 text-red-200',
        };
    }
}
