<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default warehouse
        $warehouse = Warehouse::firstOrCreate(
            ['name' => 'Main Warehouse'],
            [
                'address' => 'Jakarta, Indonesia',
                'type' => 'warehouse',
                'capacity' => 10000,
                'status' => 'active',
            ]
        );

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@fiaexpress.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'warehouse_id' => $warehouse->id,
            ]
        );

        // Create manager user
        User::firstOrCreate(
            ['email' => 'manager@fiaexpress.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'warehouse_id' => $warehouse->id,
            ]
        );

        // Create staff user
        User::firstOrCreate(
            ['email' => 'staff@fiaexpress.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'warehouse_id' => $warehouse->id,
            ]
        );
    }
}
