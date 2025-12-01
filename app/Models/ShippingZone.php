<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'countries',
        'shipping_rates',
        'estimated_delivery',
    ];

    protected $casts = [
        'countries' => 'array',
        'shipping_rates' => 'array',
        'estimated_delivery' => 'integer',
    ];

    /**
     * Get the outbound shipments for this shipping zone.
     */
    public function outboundShipments(): HasMany
    {
        return $this->hasMany(OutboundShipment::class);
    }

    /**
     * Find shipping zone by country code.
     */
    public static function findByCountry(string $countryCode): ?self
    {
        return self::whereJsonContains('countries', $countryCode)->first();
    }

    /**
     * Check if zone includes country.
     */
    public function includesCountry(string $countryCode): bool
    {
        return in_array($countryCode, $this->countries ?? []);
    }
}
