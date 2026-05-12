<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'service_name',
    'price',
    'unit'
])]

class Service extends Model
{
    use HasFactory;

    // Relasi transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}