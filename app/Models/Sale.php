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
        'finalized',
        'branch'
    ];

    protected $casts = [
        'date' => 'date',
        'subtotal_cost' => 'decimal:2',
        'discount_perc' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'finalized' => 'boolean'
    ];

    // Add this appends to automatically include calculated fields
    protected $appends = ['total_items', 'formatted_time', 'formatted_date'];

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
     * Get the total items count for this sale
     */
    public function getTotalItemsAttribute()
    {
        // Load relationships if not already loaded
        if (!$this->relationLoaded('productCartItems')) {
            $this->load('productCartItems');
        }
        if (!$this->relationLoaded('serviceCartItems')) {
            $this->load('serviceCartItems');
        }

        return $this->productCartItems->sum('quantity') + $this->serviceCartItems->sum('quantity');
    }

    /**
     * Get formatted created time
     */
    public function getFormattedTimeAttribute()
    {
        return $this->created_at ? $this->created_at->format('g:i A') : '';
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('n/j/Y') : '';
    }

    // Scopes for easy querying
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeFinalized($query)
    {
        return $query->where('finalized', true);
    }

    public function scopeForBranch($query, $branch)
    {
        return $query->where('branch', $branch);
    }

    public function scopeThisWeek($query)
    {
        return $query->where('date', '>=', now()->startOfWeek());
    }

    public function scopeThisMonth($query)
    {
        return $query->where('date', '>=', now()->startOfMonth());
    }

    public function scopeThisYear($query)
    {
        return $query->where('date', '>=', now()->startOfYear());
    }

    // Prevent model deletion
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($sale) {
            return false; // Prevent deletion
        });
    }
}