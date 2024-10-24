<?php

namespace App\Models;

use App\Enums\TransactionMethod;
use App\Enums\TransactionType;
use App\Models\Concerns\HasSince;
use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    use HasFactory, HasSince;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'note',
        'method',
        'type',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'amount' => 0,
        'method' => TransactionMethod::Cash,
        'type' => TransactionType::Payment,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'method' => TransactionMethod::class,
            'type' => TransactionType::class,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include transactions of a given method.
     */
    public function scopeOfMethod(Builder $query, TransactionMethod $method): void
    {
        $query->where('method', $method->value);
    }

    /**
     * Scope a query to only include transactions of a given type.
     */
    public function scopeOfType(Builder $query, TransactionType $type): void
    {
        $query->where('type', $type->value);
    }

    /**
     * Scope a query to only include payments.
     */
    public function scopePayments(Builder $query): void
    {
        $query->ofType(TransactionType::Payment);
    }

    /**
     * Scope a query to only include discounts.
     */
    public function scopeDiscounts(Builder $query): void
    {
        $query->ofType(TransactionType::Discount);
    }

    /**
     * Scope a query to only include claims.
     */
    public function scopeClaims(Builder $query): void
    {
        $query->ofType(TransactionType::Claim);
    }

    /**
     * Scope a query to only include refunds.
     */
    public function scopeRefunds(Builder $query): void
    {
        $query->ofType(TransactionType::Refund);
    }
}
