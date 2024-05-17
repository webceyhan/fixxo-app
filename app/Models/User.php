<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Traits\HasSince;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'remember_token' => null,
        'role' => UserRole::Technician,
        'status' => UserStatus::Active,
        'email_verified_at' => null,
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => UserRole::class,
        'status' => UserStatus::class,
        'email_verified_at' => 'datetime',
    ];

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

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->latest();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
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
