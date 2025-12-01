<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InboundShipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'customer_id',
        'received_date',
        'status',
        'total_items',
        'notes',
    ];

    protected $casts = [
        'received_date' => 'date',
        'total_items' => 'integer',
    ];

    /**
     * Get the customer that owns the inbound shipment.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the packages in this inbound shipment.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
