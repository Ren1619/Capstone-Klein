<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $primaryKey = 'sale_ID';

    protected $fillable = [
        'customer_name',
        'date',
        'subtotal_cost',
        'discount_perc',
        'total_cost',
        'finalized'
    ];

    protected $casts = [
        'date' => 'date',
        'subtotal_cost' => 'decimal:2',
        'discount_perc' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'finalized' => 'boolean'
    ];

    /**
     * Get the product cart items for the sale.
     */
    public function productCartItems(): HasMany
    {
        return $this->hasMany(ProductCartItem::class, 'sale_ID', 'sale_ID');
    }

    /**
     * Get the service cart items for the sale.
     */
    public function serviceCartItems(): HasMany
    {
        return $this->hasMany(ServiceCartItem::class, 'sale_ID', 'sale_ID');
    }

    /**
     * Prevent model deletion
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($sale) {
            return false; // Prevent deletion
        });
    }
}