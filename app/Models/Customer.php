<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Enums\UserStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
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
        'company' => null,
        'vat' => null,
        'address' => null,
        'phone' => null,
        'email' => null,
        'note' => null,
        'status' => UserStatus::ACTIVE,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => UserStatus::class,
    ];

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'company',
        'vat',
        'address',
        'phone',
        'email',
    ];

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class)->latest();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->latest();
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include customers with outstanding (< 0) balance.
     */
    public function scopeWithOutstandingBalance(Builder $query): Builder
    {
        return $query->where('balance', '<', 0);
    }

    /**
     * Scope a query to only include customers with open tickets.
     */
    public function scopeWithOpenTickets(Builder $query): void
    {
        $query->where('total_tickets_count', '>', 0)
            ->where('closed_tickets_count', '<', $this->total_tickets_count);
    }

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set balance.
     */
    public function setBalance(): self
    {
        $this->balance = $this->tickets->sum('balance');

        return $this;
    }

    /**
     * Set ticket counters.
     */
    public function setTicketCounters(): self
    {
        $this->total_tickets_count = $this->tickets->count();
        // @see Ticket::setTaskCounters() for more info
        // $this->open_tickets_count = $this->tickets()->closed()->count();
        $this->closed_tickets_count = $this->tickets->where('status', TicketStatus::CLOSED)->count();

        return $this;
    }
}
