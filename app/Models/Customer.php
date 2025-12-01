<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'country',
        'tax_id',
    ];

    /**
     * Get the inbound shipments for this customer.
     */
    public function inboundShipments(): HasMany
    {
        return $this->hasMany(InboundShipment::class);
    }

    /**
     * Get the outbound shipments for this customer.
     */
    public function outboundShipments(): HasMany
    {
        return $this->hasMany(OutboundShipment::class);
    }
}
