<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_ID';

    protected $fillable = [
        'category_ID',
        'branch_ID',
        'name',
        'measurement_unit',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_ID', 'category_ID');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_ID', 'branch_ID');
    }

    public function getStatusAttribute()
    {
        if ($this->quantity == 0) {
            return 'out of stock';
        } elseif ($this->quantity < 10) {
            return 'low stock';
        } else {
            return 'in stock';
        }
    }

    public function getStatusColorAttribute()
    {
        if ($this->quantity == 0) {
            return 'bg-red-500/30 text-red-700';
        } elseif ($this->quantity < 10) {
            return 'bg-yellow-500/30 text-yellow-700';
        } else {
            return 'bg-green-500/30 text-green-700';
        }
    }
}