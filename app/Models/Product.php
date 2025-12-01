<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'weight',
        'dimensions',
        'value',
        'stock_quantity',
        'location_id',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'value' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the warehouse location where the product is stored.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'location_id');
    }

    /**
     * Get the packages that contain this product.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
