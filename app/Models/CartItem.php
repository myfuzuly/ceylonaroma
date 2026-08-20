<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'customer_id','product_id','product_name','product_slug',
        'product_image','product_category','qty',
    ];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function product()  { return $this->belongsTo(Product::class); }
}
