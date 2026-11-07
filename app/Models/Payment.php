<?php
namespace App\Models;

use App\Enums\{Coin, PaymentStatus};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['coin' => Coin::class, 'status' => PaymentStatus::class, 'verified_at' => 'datetime', 'amount_usd' => 'decimal:2'];
    }

    public function quote(): BelongsTo { return $this->belongsTo(Quote::class); }
}
