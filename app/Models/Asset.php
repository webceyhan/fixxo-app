<?php

namespace App\Models;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
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
use Illuminate\Support\Facades\DB;

class Asset extends Model
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
        'brand' => null,
        'type' => null,
        'serial' => null,
        'purchase_date' => null,
        'warranty' => 0,
        'problem' => null,
        'notes' => null,
        'status' => AssetStatus::IN_PROGRESS,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'warranty_date',
    ];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,serial,problem';

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////


    /**
     * Get warranty expiration date from purchase date + warranty months.
     * If 0 returned, meaning there is no warranty at all.
     */
    protected function warrantyDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                // check if purchase nor warranty dates set
                if (!$this->purchase_date || !$this->warranty) {
                    return null; // skip, meaning no warranty
                }

                // try to cast dates with carbon
                $purchaseDate = Carbon::parse($this->purchase_date);
                $warrantyDate = $purchaseDate->addMonths($this->warranty);

                return $warrantyDate->toDateString();
            },
        )->shouldCache();
    }


    /**
     * Get sum of all tasks prices.
     */
    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tasks->pluck('price')->sum(),
        )->shouldCache();
    }

    /**
     * Get a map of payment sums by their type.
     */
    protected function balanceMap(): Attribute
    {
        return Attribute::make(
            get: function () {
                // initialize map in a specific order
                $map = array_fill_keys(PaymentType::values(), 0);

                // populate map with sums
                $this->payments->each(function ($payment) use (&$map) {
                    $map[$payment->type] += $payment->amount;
                });

                return $map;
            },
        )->shouldCache();
    }

    /**
     * Get balance calculated from total cost & payments.
     */
    protected function balance(): Attribute
    {
        return Attribute::make(
            get: function () {
                // extract vars
                [
                    'charge' => $charge,
                    'discount' => $discount,
                    'warranty' => $warranty,
                ] = $this->balanceMap;

                return $charge - $this->cost + (abs($discount) + abs($warranty));
            }
        );
    }

    /**
     * Get url to qr code.
     *
     * @return bool
     */
    protected function qrUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $linkData = route('assets.show', $this);
                return QRService::urlFor($this->id, $linkData);
            }
        );
    }

    /**
     * Get url to the intake signature.
     */
    protected function intakeSignatureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-intake'),
            // TODO: find a way to make this work!
            // Attribute::make() doesn't support setting value that doesn't exist in the model
            // set: fn ($value) => SignatureService::put($this->id . '-intake', $value),
        );
    }

    /**
     * Get url to the delivery signature.
     */
    protected function deliverySignatureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-delivery'),
            // TODO: see above!
            // set: fn ($value) => SignatureService::put($this->id . '-delivery', $value),
        );
    }

    /**
     * Get an array of uploaded file urls.
     */
    protected function uploadedUrls(): Attribute
    {
        return Attribute::make(
            get: fn () => UploadService::urls($this->id)
        );
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): belongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->latest();
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include in_progress assets.
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', AssetStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include ready assets.
     */
    public function scopeReady(Builder $query): void
    {
        $query->where('status', AssetStatus::READY);
    }

    /**
     * Scope a query to only include returned assets.
     */
    public function scopeReturned(Builder $query): void
    {
        $query->where('status', AssetStatus::RETURNED);
    }

    /**
     * Get all assets with their cost (sum of its tasks) and paid amount (sum of its payments) 
     * ordered by their balance which is the difference between cost and paid amount.
     */
    public function scopeUnpaid(Builder $query): void
    {
        // todo: make this calculations on the model level using precalculated attributes 
        // and fetch using scope variables to build different queries
        $query->returned()
            ->select(
                'assets.*',
                DB::raw('COALESCE(t.cost, 0) AS cost'),
                DB::raw('ABS(COALESCE(p.amount, 0)) AS paid'),
                // bugfix: balance is defined attribute in modal so we should use different name: "balanceD"
                DB::raw('ABS(COALESCE(p.amount, 0)) - COALESCE(t.cost, 0) AS balanced')
            )
            ->leftJoin(DB::raw('(SELECT asset_id, SUM(price) AS cost FROM tasks GROUP BY asset_id) t'), function ($join) {
                $join->on('assets.id', '=', 't.asset_id');
            })
            ->leftJoin(DB::raw('(SELECT asset_id, SUM(IF(type="refund", -ABS(amount), ABS(amount))) AS amount FROM payments GROUP BY asset_id) p'), function ($join) {
                $join->on('assets.id', '=', 'p.asset_id');
            })
            ->having('balanced', '<', 0);
    }

    /**
     * Scope a query to retrieve all brands sorted by their frequency.
     */
    public function scopeBrands(Builder $query): void
    {
        $query->select('brand')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByRaw('COUNT(brand) DESC');
    }

    /**
     * Scope a query to get statistics grouped by status.
     */
    public function scopeStats(Builder $query): void
    {
        $query->selectRaw('COUNT(id) as value, status as label')
            ->whereNot('status', 'returned') // exclude returned
            ->groupBy('status');
    }
}
