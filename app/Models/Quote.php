<?php
namespace App\Models;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Quote extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['status' => QuoteStatus::class, 'consultation' => 'boolean', 'studio_notified_at' => 'datetime', 'price' => 'decimal:2', 'deposit' => 'decimal:2'];
    }

    public function artist(): BelongsTo { return $this->belongsTo(Artist::class); }
    public function payments(): HasMany { return $this->hasMany(Payment::class)->latest(); }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        return $term ? $q->where(fn ($w) => $w->where('name', 'like', "%$term%")->orWhere('email', 'like', "%$term%")) : $q;
    }

    /** A client may pay once a quote with a deposit exists and no payment is awaiting review. */
    public function isPayable(): bool { return $this->status === QuoteStatus::Quoted && (float) $this->deposit > 0; }
}
