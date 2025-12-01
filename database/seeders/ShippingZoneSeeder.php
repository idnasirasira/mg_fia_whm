<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Asia Pacific',
                'countries' => ['ID', 'MY', 'SG', 'TH', 'VN', 'PH', 'JP', 'KR', 'CN', 'HK', 'TW', 'IN', 'AU', 'NZ'],
                'shipping_rates' => [
                    'base_rate' => 15.00,
                    'per_kg_rate' => 5.00,
                ],
                'estimated_delivery' => 7,
            ],
            [
                'name' => 'Europe',
                'countries' => ['GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'AT', 'SE', 'NO', 'DK', 'FI', 'PL', 'CZ', 'GR', 'PT', 'IE'],
                'shipping_rates' => [
                    'base_rate' => 25.00,
                    'per_kg_rate' => 8.00,
                ],
                'estimated_delivery' => 10,
            ],
            [
                'name' => 'Americas',
                'countries' => ['US', 'CA', 'MX', 'BR', 'AR', 'CL'],
                'shipping_rates' => [
                    'base_rate' => 30.00,
                    'per_kg_rate' => 10.00,
                ],
                'estimated_delivery' => 12,
            ],
            [
                'name' => 'Middle East & Africa',
                'countries' => ['AE', 'SA', 'ZA'],
                'shipping_rates' => [
                    'base_rate' => 20.00,
                    'per_kg_rate' => 7.00,
                ],
                'estimated_delivery' => 9,
            ],
        ];

        foreach ($zones as $zone) {
            ShippingZone::firstOrCreate(
                ['name' => $zone['name']],
                $zone
            );
        }
    }
}
