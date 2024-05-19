<?php

namespace App\Models;

use App\Enums\TransactionMethod;
use App\Enums\TransactionType;
use App\Models\Concerns\HasSince;
use App\Observers\TransactionObserver;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $ticket_id
 * @property float $amount
 * @property string|null $note
 * @property TransactionMethod $method
 * @property TransactionType $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read Ticket $ticket
 * 
 * @method static TransactionFactory factory(int $count = null, array $state = [])
 * @method static Builder|static asPayment()
 * @method static Builder|static asDiscount()
 * @method static Builder|static asWarranty()
 * @method static Builder|static asRefund()
 * @method static Builder|static byCash()
 * @method static Builder|static byCard()
 * @method static Builder|static byOnline()
 */
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
        'ticket_id', // TODO: remove later! It must be validated by the controller
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
        'type' => TransactionType::Payment,
        'method' => TransactionMethod::Cash,
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
        return $query->where('type', TransactionType::Payment);
    }

    /**
     * Scope a query to only include transactions as discount.
     */
    public function scopeAsDiscount(Builder $query): Builder
    {
        return $query->where('type', TransactionType::Discount);
    }

    /**
     * Scope a query to only include transactions as warranty reimbursement.
     */
    public function scopeAsWarranty(Builder $query): Builder
    {
        return $query->where('type', TransactionType::Warranty);
    }

    /**
     * Scope a query to only include transactions as refund.
     */
    public function scopeAsRefund(Builder $query): Builder
    {
        return $query->where('type', TransactionType::Refund);
    }

    /**
     * Scope a query to only transactions by cash.
     */
    public function scopeByCash(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::Cash);
    }

    /**
     * Scope a query to only transactions by card.
     */
    public function scopeByCard(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::Card);
    }

    /**
     * Scope a query to only transactions by online.
     */
    public function scopeByOnline(Builder $query): Builder
    {
        return $query->where('method', TransactionMethod::Online);
    }
}
