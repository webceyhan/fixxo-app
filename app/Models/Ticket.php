<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Enums\PaymentType;
use App\Services\QRService;
use App\Services\SignatureService;
use App\Services\UploadService;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
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
        'note' => null,
        'status' => TicketStatus::NEW,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'issue';


    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    // /**
    //  * Get sum of all tasks prices.
    //  */
    // protected function cost(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->tasks->pluck('price')->sum(),
    //     )->shouldCache();
    // }

    // /**
    //  * Get a map of payment sums by their type.
    //  */
    // protected function balanceMap(): Attribute
    // {
    //     return Attribute::make(
    //         get: function () {
    //             // initialize map in a specific order
    //             $map = array_fill_keys(PaymentType::values(), 0);

    //             // populate map with sums
    //             $this->payments->each(function ($payment) use (&$map) {
    //                 $map[$payment->type] += $payment->amount;
    //             });

    //             return $map;
    //         },
    //     )->shouldCache();
    // }

    // /**
    //  * Get balance calculated from total cost & payments.
    //  */
    // protected function balance(): Attribute
    // {
    //     return Attribute::make(
    //         get: function () {
    //             // extract vars
    //             [
    //                 'charge' => $charge,
    //                 'discount' => $discount,
    //                 'warranty' => $warranty,
    //             ] = $this->balanceMap;

    //             return $charge - $this->cost + (abs($discount) + abs($warranty));
    //         }
    //     );
    // }

    /**
     * Get URL to qr code or generate if not exists.
     *
     * @return bool
     */
    protected function qrUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $linkData = route('tickets.show', $this);
                return QRService::urlFor($this->id, $linkData);
            }
        );
    }

    // /**
    //  * Get url to the intake signature.
    //  */
    // protected function intakeSignatureUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => SignatureService::url($this->id . '-intake'),
    //         // TODO: find a way to make this work!
    //         // Attribute::make() doesn't support setting value that doesn't exist in the model
    //         // set: fn ($value) => SignatureService::put($this->id . '-intake', $value),
    //     );
    // }

    // /**
    //  * Get url to the delivery signature.
    //  */
    // protected function deliverySignatureUrl(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => SignatureService::url($this->id . '-delivery'),
    //         // TODO: see above!
    //         // set: fn ($value) => SignatureService::put($this->id . '-delivery', $value),
    //     );
    // }

    /**
     * Get an array URL's to uploaded files.
     */
    protected function uploadedUrls(): Attribute
    {
        return Attribute::make(
            get: fn () => UploadService::urls('tickets/' . $this->id)
        );
    }


    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device(): belongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(
            Customer::class,
            Device::class,
            'id', // Foreign key on the devices table...
            'id', // Foreign key on the customers table...
            'device_id', // Local key on the tickets table...
            'customer_id' // Local key on the devices table...
        );
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Payment::class)->latest();
    // }


    // EVENTS //////////////////////////////////////////////////////////////////////////////////////

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function (Ticket $ticket) {
        });
    }


    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include new Tickets.
     */
    public function scopeNew(Builder $query): void
    {
        $query->where('status', TicketStatus::NEW);
    }

    /**
     * Scope a query to only include in_progress Tickets.
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', TicketStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include on-hold Tickets.
     */
    public function scopeOnHold(Builder $query): void
    {
        $query->where('status', TicketStatus::ON_HOLD);
    }

    /**
     * Scope a query to only include resolved Tickets.
     */
    public function scopeResolved(Builder $query): void
    {
        $query->where('status', TicketStatus::RESOLVED);
    }

    /**
     * Scope a query to only include closed Tickets.
     */
    public function scopeClosed(Builder $query): void
    {
        $query->where('status', TicketStatus::CLOSED);
    }

    /**
     * Get all tickets with their cost (sum of its tasks) and paid amount (sum of its payments) 
     * ordered by their balance which is the difference between cost and paid amount.
     */
    public function scopeUnpaid(Builder $query): void
    {
        // todo: make this calculations on the model level using precalculated attributes 
        // and fetch using scope variables to build different queries
        $query->returned()
            ->select(
                'tickets.*',
                DB::raw('COALESCE(t.cost, 0) AS cost'),
                DB::raw('ABS(COALESCE(p.amount, 0)) AS paid'),
                // bugfix: balance is defined attribute in modal so we should use different name: "balanceD"
                DB::raw('ABS(COALESCE(p.amount, 0)) - COALESCE(t.cost, 0) AS balanced')
            )
            ->leftJoin(DB::raw('(SELECT ticket_id, SUM(price) AS cost FROM tasks GROUP BY ticket_id) t'), function ($join) {
                $join->on('tickets.id', '=', 't.ticket_id');
            })
            ->leftJoin(DB::raw('(SELECT ticket_id, SUM(IF(type="refund", -ABS(amount), ABS(amount))) AS amount FROM payments GROUP BY ticket_id) p'), function ($join) {
                $join->on('tickets.id', '=', 'p.ticket_id');
            })
            ->having('balanced', '<', 0);
    }

    /**
     * Scope a query to get statistics grouped by status.
     */
    public function scopeStats(Builder $query): void
    {
        $query->selectRaw('COUNT(id) as value, status as label')
            ->whereNot('status', TicketStatus::CLOSED)
            ->groupBy('status');
    }
}
