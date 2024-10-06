<?php

namespace App\Models;

use App\Models\Concerns\HasDueDate;
use App\Models\Concerns\HasSince;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $ticket_id
 * @property float $total
 * @property Carbon $due_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read float $tasks_cost
 * @property-read float $orders_cost
 * @property-read float $total_paid
 * @property-read float $balance
 * @property-read bool $is_paid
 * 
 * @property-read Ticket $ticket
 * @property-read Collection<int, Transaction> $transactions
 * 
 * @method static InvoiceFactory factory(int $count = null, array $state = [])
 * @method static Builder|static unpaid()
 */
class Invoice extends Model
{
    use HasFactory, HasSince, HasDueDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total',
        'due_date',
        'balance',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'total' => 0,
        'balance' => 0,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total' => 'float',
            'due_date' => 'date',
            'balance' => 'float',
        ];
    }

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get total cost of billable tasks.
     */
    protected function tasksCost(): Attribute
    {
        return Attribute::get(
            fn() => (float) $this->ticket->tasks()->billable()->sum('cost')
        );
    }

    /**
     * Get total cost of billable orders.
     */
    protected function ordersCost(): Attribute
    {
        return Attribute::get(
            fn() => (float) $this->ticket->orders()->billable()->sum('cost')
        );
    }

    /**
     * Get total amount paid.
     */
    protected function totalPaid(): Attribute
    {
        return Attribute::get(
            fn() => (float) $this->transactions()->sum('amount')
        );
    }

    /**
     * Get whether the invoice is paid.
     */
    protected function isPaid(): Attribute
    {
        return Attribute::get(fn() => $this->balance >= 0);
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Fill the invoice's balance automatically.
     */
    public function fillBalance(): self
    {
        // fill total cost of billable tasks and orders
        $this->total = $this->tasks_cost + $this->orders_cost;

        // fill remaining balance
        $this->balance = $this->total_paid - $this->total;

        return $this;
    }

    protected function overdueCondition(): bool
    {
        return !$this->is_paid;
    }

    protected function overdueConditionQuery(Builder $query): void
    {
        $query->unpaid();
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid(Builder $query): void
    {
        $query->where('balance', '<', 0);
    }
}
