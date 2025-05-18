<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class VisitProduct extends Model
{
    use HasFactory;

    protected $table = 'visit_products';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'visit_products_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'visit_ID',
        'product_ID',
        'note',
    ];

    /**
     * Get the visit that owns the product.
     */
    public function visit()
    {
        return $this->belongsTo(VisitHistory::class, 'visit_ID', 'visit_ID');
    }

    /**
     * Get the product that is used.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_ID', 'product_ID');
    }

    /**
     * Get the patient through the visit.
     */
    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            VisitHistory::class,
            'visit_ID',
            'PID',
            'visit_ID',
            'PID'
        );
    }
}