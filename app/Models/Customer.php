<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $company
 * @property string|null $vat_number
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read float $balance
 * @property-read int $closed_tickets_count
 * @property-read int $total_tickets_count
 * 
 * @property-read Collection<int, Device> $devices
 * @property-read Collection<int, Ticket> $tickets
 *
 * @method static CustomerFactory factory(int $count = null, array $state = [])
 * @method static Builder|static withOutstandingBalance()
 * @method static Builder|static withOpenTickets()
 */
class Customer extends Model
{
    use HasFactory, Searchable, HasSince;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company',
        'vat_number',
        'email',
        'phone',
        'address',
        'note',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'balance' => 0,
        'total_tickets_count' => 0,
        'closed_tickets_count' => 0,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'balance' => 'float',
        ];
    }

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'company',
        'vat_number',
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
        $this->closed_tickets_count = $this->tickets->where('status', TicketStatus::Closed)->count();

        return $this;
    }
}
