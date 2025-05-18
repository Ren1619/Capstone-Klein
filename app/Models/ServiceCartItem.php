<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCartItem extends Model
{
    protected $primaryKey = 'cart_ID';

    protected $fillable = [
        'sale_ID',
        'service_ID',
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
     * Get the service that owns the cart item.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_ID', 'service_ID');
    }

    /**
     * Get the total cost for this cart item
     */
    public function getTotalCostAttribute()
    {
        return $this->service ? ($this->service->price * $this->quantity) : 0;
    }

    /**
     * Scope for filtering by sale
     */
    public function scopeForSale($query, $saleId)
    {
        return $query->where('sale_ID', $saleId);
    }

    /**
     * Scope for filtering by service
     */
    public function scopeForService($query, $serviceId)
    {
        return $query->where('service_ID', $serviceId);
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