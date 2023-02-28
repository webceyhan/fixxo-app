<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
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
        'amount' => 0,
        'type' => PaymentType::CHARGE,
        'method' => PaymentMethod::CASH,
        'notes' => null,
    ];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'notes';

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
