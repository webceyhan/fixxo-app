<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Concerns\HasSince;
use App\Models\Concerns\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property string $remember_token
 * @property UserRole $role
 * @property UserStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $email_verified_at
 * 
 * @property-read bool $is_admin
 * 
 * @property-read Collection<int, Ticket> $assignedTickets
 *
 * @method static UserFactory factory(int $count = null, array $state = [])
 * @method static Builder|static admins()
 * @method static Builder|static managers()
 * @method static Builder|static technicians()
 */
class User extends Authenticatable
{
    use  HasFactory, Notifiable, Searchable, HasSince;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => UserRole::Technician,
        'status' => UserStatus::Active,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    protected $searchable = [
        'name',
        'email',
        'phone',
    ];

    // ACCESSORS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the flag whether if user has admin role or not.
     */
    protected function isAdmin(): Attribute
    {
        return Attribute::get(fn () => $this->role->isAdmin());
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_id');
    }

    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmin(Builder $query): void
    {
        $query->where('role', UserRole::Admin);
    }

    /**
     * Scope a query to only include manager users.
     */
    public function scopeManager(Builder $query): void
    {
        $query->where('role', UserRole::Manager);
    }

    /**
     * Scope a query to only include technician users.
     */
    public function scopeTechnician(Builder $query): void
    {
        $query->where('role', UserRole::Technician);
    }
}
