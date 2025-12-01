<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutboundShipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'customer_id',
        'shipping_date',
        'carrier',
        'destination_country',
        'status',
        'customs_value',
        'shipping_cost',
        'shipping_zone_id',
    ];

    protected $casts = [
        'shipping_date' => 'date',
        'customs_value' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the outbound shipment.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the shipping zone for this shipment.
     */
    public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    /**
     * Get the packages in this outbound shipment.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
