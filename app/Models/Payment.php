<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use App\Traits\Model\HasSince;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
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
        'type' => PaymentType::CHARGE,
        'method' => PaymentMethod::CASH,
        'note' => null,
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
     * Scope a query to only include payments as charge.
     */
    public function scopeAsCharge(Builder $query): Builder
    {
        return $query->where('type', PaymentType::CHARGE);
    }

    /**
     * Scope a query to only include payments as discount.
     */
    public function scopeAsDiscount(Builder $query): Builder
    {
        return $query->where('type', PaymentType::DISCOUNT);
    }

    /**
     * Scope a query to only include payments as warranty reimbursement.
     */
    public function scopeAsWarranty(Builder $query): Builder
    {
        return $query->where('type', PaymentType::WARRANTY);
    }

    /**
     * Scope a query to only include payments as refund.
     */
    public function scopeAsRefund(Builder $query): Builder
    {
        return $query->where('type', PaymentType::REFUND);
    }

    /**
     * Scope a query to only payments by cash.
     */
    public function scopeByCash(Builder $query): Builder
    {
        return $query->where('method', PaymentMethod::CASH);
    }

    /**
     * Scope a query to only payments by card.
     */
    public function scopeByCard(Builder $query): Builder
    {
        return $query->where('method', PaymentMethod::CARD);
    }

    /**
     * Scope a query to only payments by online.
     */
    public function scopeByOnline(Builder $query): Builder
    {
        return $query->where('method', PaymentMethod::ONLINE);
    }

    // EVENTS //////////////////////////////////////////////////////////////////////////////////////

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // TODO: improve this logic!
        // make the calculation consistent with the payment type
        // so it can be easily summed up on db level (see Ticket::balance)
        static::saving(function (Payment $payment) {
            // normalize amount signature based on the payment type
            $sign = ($payment->type === PaymentType::CHARGE) ? '+' : '-';
            $payment->amount = (float) ($sign . abs($payment->amount));
        });
    }
}
