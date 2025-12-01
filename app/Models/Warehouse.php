<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'address',
        'type',
        'capacity',
        'status',
    ];

    /**
     * Get the users assigned to this warehouse.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the products stored in this warehouse.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'location_id');
    }

    /**
     * Get the packages stored in this warehouse.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'location_id');
    }
}
