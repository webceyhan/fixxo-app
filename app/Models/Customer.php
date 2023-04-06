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
     * Update aggregate fields.
     */
    public function updateAggregateFields(): void
    {
        $this->calculateBalance();
        $this->calculateTicketCounters();

        $this->save();
    }

    /**
     * Calculate total balance of all tickets.
     */
    public function calculateBalance(): void
    {
        $this->balance = $this->tickets->sum('balance');
    }

    /**
     * Calculate total and open ticket counters.
     */
    public function calculateTicketCounters(): void
    {
        $tickets = $this->tickets;

        $this->total_tickets_count = $tickets->count();
        $this->closed_tickets_count = $tickets->where('status', TicketStatus::CLOSED)->count();
    }
}
