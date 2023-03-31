<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory, Searchable, HasSince;

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
        'url' => null,
        'quantity' => 1,
        'cost' => 0,
        'note' => null,
        'status' => OrderStatus::NEW,
    ];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,url,note';

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): belongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include new orders.
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', OrderStatus::NEW);
    }

    /**
     * Scope a query to only include shipped orders.
     */
    public function scopeShipped(Builder $query): void
    {
        $query->where('status', OrderStatus::SHIPPED);
    }

    /**
     * Scope a query to only include received orders.
     */
    public function scopeReceived(Builder $query): void
    {
        $query->where('status', OrderStatus::RECEIVED);
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled(Builder $query): void
    {
        $query->where('status', OrderStatus::CANCELLED);
    }
}
