<?php

namespace App\Models;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Enums\PaymentType;
use App\Services\QRService;
use App\Services\SignatureService;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,serial,problem';

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

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
     * Interact with asset's intake signature.
     */
    protected function intakeSignature(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-intake'),
            // TODO: find a way to make this work!
            // Attribute::make() doesn't support setting value that doesn't exist in the model
            // set: fn ($value) => SignatureService::put($this->id . '-intake', $value),
        );
    }

    /**
     * Interact with asset's delivery signature.
     */
    protected function deliverySignature(): Attribute
    {
        return Attribute::make(
            get: fn () => SignatureService::url($this->id . '-delivery'),
            // TODO: see above!
            // set: fn ($value) => SignatureService::put($this->id . '-delivery', $value),
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
     * @param Builder $query
     * @return Builder
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('status', AssetStatus::IN_PROGRESS);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeReady(Builder $query): void
    {
        $query->where('status', AssetStatus::READY);
    }
}
