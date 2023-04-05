<?php

namespace App\Models;

use App\Enums\TransactionMethod;
use App\Enums\TransactionType;
use App\Models\Traits\HasSince;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasSince;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'amount' => 0,
        'type' => TransactionType::PAYMENT,
        'method' => TransactionMethod::CASH,
        'note' => null,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => TransactionType::class,
        'method' => TransactionMethod::class,
    ];

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include transactions as payment.
     */
    public function scopeAsPayment(Builder $query): Builder
    {
        return $query->where('type', TransactionType::PAYMENT);
    }

    /**
     * Scope a query to only include transactions as discount.
     */
    public function scopeAsDiscount(Builder $query): Builder
    {
        return $query->where('type', TransactionType::DISCOUNT);
    }

    /**
     * Scope a query to only include transactions as warranty reimbursement.
     */
    public function scopeAsWarranty(Builder $query): Builder
    {
        return $query->where('type', TransactionType::WARRANTY);
    }

    /**
     * Scope a query to only include transactions as refund.
     */
    public function scopeAsRefund(Builder $query): Builder
    {
        return $query->where('type', TransactionType::REFUND);
    }

    /**
     * Scope a query to only transactions by cash.
     */
    public function scopeByCash(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::CASH);
    }

    /**
     * Scope a query to only transactions by card.
     */
    public function scopeByCard(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::CARD);
    }

    /**
     * Scope a query to only transactions by online.
     */
    public function scopeByOnline(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::ONLINE);
    }
}
