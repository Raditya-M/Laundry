<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'name',
    'username',
    'password',
    'role',
    'phone',
    'address',
    'is_member',
    'membership_expired_at'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_expired_at' => 'datetime',
        ];
    }

    public function getMembershipActiveAttribute()
    {
        return $this->is_member &&
            $this->membership_expired_at &&
            now()->lt($this->membership_expired_at);
    }

    // Relasi customer profile
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    // Relasi transaksi admin
    public function adminTransactions()
    {
        return $this->hasMany(Transaction::class, 'admin_id');
    }
}
