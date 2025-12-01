<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    protected $fillable = [
        'inbound_shipment_id',
        'outbound_shipment_id',
        'product_id',
        'quantity',
        'weight',
        'dimensions',
        'value',
        'status',
        'location_id',
        'customs_info',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'weight' => 'decimal:2',
        'value' => 'decimal:2',
        'customs_info' => 'array',
    ];

    /**
     * Get the inbound shipment that contains this package.
     */
    public function inboundShipment(): BelongsTo
    {
        return $this->belongsTo(InboundShipment::class);
    }

    /**
     * Get the outbound shipment that contains this package.
     */
    public function outboundShipment(): BelongsTo
    {
        return $this->belongsTo(OutboundShipment::class);
    }

    /**
     * Get the product in this package.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the warehouse location where the package is stored.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'location_id');
    }
}
