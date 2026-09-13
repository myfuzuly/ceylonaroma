<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id','name','slug','sku','short_description','description',
        'image','gallery','variants',
        'price','price_unit','currency','min_order_qty','min_order_unit',
        'weight_per_unit','origin','certifications','shelf_life',
        'stock_qty','low_stock_threshold','in_stock',
        'is_featured','is_bestseller','is_new_arrival','is_export_ready',
        'sort_order','status',
    ];

    protected $casts = [
        'gallery'              => 'array',
        'variants'             => 'array',
        'price'                => 'decimal:2',
        'min_order_qty'        => 'decimal:2',
        'weight_per_unit'      => 'decimal:2',
        'stock_qty'            => 'integer',
        'low_stock_threshold'  => 'integer',
        'in_stock'             => 'boolean',
        'is_featured'          => 'boolean',
        'is_bestseller'        => 'boolean',
        'is_new_arrival'       => 'boolean',
        'is_export_ready'      => 'boolean',
        'status'               => 'boolean',
    ];

    public function isLowStock(): bool
    {
        return $this->stock_qty !== null && $this->stock_qty <= $this->low_stock_threshold;
    }

    public function formattedPrice(): string
    {
        if (!$this->price) return 'Price on Request';
        return $this->currency . ' ' . number_format($this->price, 2) . ' / ' . $this->price_unit;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wholesalePrice()
    {
        return $this->hasOne(WholesalePrice::class)->latestOfMany();
    }

    public function wholesalePrices()
    {
        return $this->hasMany(WholesalePrice::class)->latest();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
