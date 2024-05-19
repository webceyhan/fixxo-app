<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\Concerns\Cancellable;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use App\Observers\OrderObserver;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $ticket_id
 * @property string $name
 * @property string|null $url
 * @property int $quantity
 * @property float $cost
 * @property OrderStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read Ticket $ticket
 * 
 * @method static OrderFactory factory(int $count = null, array $state = [])
 * @method static Builder|static ofStatus(OrderStatus $status)
 * @method static Builder|static new()
 * @method static Builder|static shipped()
 * @method static Builder|static received()
 */
#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory, Searchable, HasSince, Cancellable;

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'url',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_id', // TODO: remove later! It must be validated by the controller
        'name',
        'url',
        'quantity',
        'cost',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'quantity' => 1,
        'cost' => 0,
        'status' => OrderStatus::New,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function ticket(): belongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include tasks of a given status.
     */
    public function scopeOfStatus(Builder $query, OrderStatus $status): void
    {
        $query->where('status', $status->value);
    }

    /**
     * Scope a query to only include new orders.
     */
    public function scopeNew(Builder $query): void
    {
        $query->ofStatus(OrderStatus::New);
    }

    /**
     * Scope a query to only include shipped orders.
     */
    public function scopeShipped(Builder $query): void
    {
        $query->ofStatus(OrderStatus::Shipped);
    }

    /**
     * Scope a query to only include received orders.
     */
    public function scopeReceived(Builder $query): void
    {
        $query->ofStatus(OrderStatus::Received);
    }
}
