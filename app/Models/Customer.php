<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Traits\Model\HasSince;
use App\Traits\Model\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
        'notes' => null,
        'status' => UserStatus::ACTIVE,
    ];

    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    protected $searchIndex = 'name,company,vat,address,phone,email';

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class)->latest();
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(Ticket::class, Device::class)->latest();
    }
}
