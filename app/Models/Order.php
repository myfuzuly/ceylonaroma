<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number','customer_id','name','email','phone',
        'company','country','address','notes','status','items_count',
        'payment_method','payment_status','payment_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmed'  => '#3b82f6',
            'processing' => '#f59e0b',
            'shipped'    => '#8b5cf6',
            'delivered'  => '#10b981',
            'cancelled'  => '#ef4444',
            default      => '#6b7280',
        };
    }
}
