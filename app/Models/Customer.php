<?php

namespace App\Models;

use App\Models\Concerns\Contactable;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use Database\Factories\CustomerFactory;
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
 * @property-read Collection<int, Device> $devices
 * @property-read Collection<int, Ticket> $tickets
 *
 * @method static CustomerFactory factory(int $count = null, array $state = [])
 */
class Customer extends Model
{
    use HasFactory, Searchable, HasSince, Contactable;

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'company',
        'phone',
        'email',
        'address',
    ];

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

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class)->latest();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->latest();
    }
}
