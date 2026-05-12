<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'user_id',
    'phone',
    'address'
])]

class Customer extends Model
{
    use HasFactory;

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}