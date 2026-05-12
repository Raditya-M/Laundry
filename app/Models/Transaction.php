<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'invoice_code',
    'admin_id',
    'customer_id',
    'service_id',
    'weight',
    'total_price',
    'status',
    'payment_method',
    'payment_status',
    'payment_proof',
    'paid_at'
])]

class Transaction extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    // Relasi admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}