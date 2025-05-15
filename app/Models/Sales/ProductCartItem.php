<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCartItem extends Model
{
    protected $primaryKey = 'basket_ID';

    protected $fillable = [
        'sale_ID',
        'product_ID',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    /**
     * Get the sale that owns the cart item.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_ID', 'sale_ID');
    }

    /**
     * Get the product that owns the cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_ID', 'product_ID');
    }

    /**
     * Prevent model deletion
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($cartItem) {
            return false; // Prevent deletion
        });
    }
}