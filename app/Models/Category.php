<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_ID';

    protected $fillable = [
        'category_name',
        'category_type',
        'description',
    ];

    // Define the possible category types as constants
    const TYPE_PRODUCT = 'product';
    const TYPE_SERVICE = 'service';

    /**
     * Get the products associated with this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get the services associated with this category
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_ID', 'category_ID');
    }

    /**
     * Scope a query to only include product categories
     */
    public function scopeProducts($query)
    {
        return $query->where('category_type', self::TYPE_PRODUCT);
    }

    /**
     * Scope a query to only include service categories
     */
    public function scopeServices($query)
    {
        return $query->where('category_type', self::TYPE_SERVICE);
    }
}