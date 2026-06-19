<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'paid_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'paid_until' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWarehouse(): bool
    {
        return $this->role === 'warehouse';
    }

    public function isBlocked(): bool
    {
        if (! $this->is_active) {
            return true;
        }

        if ($this->paid_until && now()->greaterThan($this->paid_until)) {
            return true;
        }

        return false;
    }
    public function costumes()
    {
        return $this->hasMany(Costume::class);
    }

    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    public function studios()
    {
        return $this->hasMany(Studio::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

}