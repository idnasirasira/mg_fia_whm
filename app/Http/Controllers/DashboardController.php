<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InboundShipment;
use App\Models\OutboundShipment;
use App\Models\Package;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_packages' => Package::count(),
            'pending_inbound' => InboundShipment::where('status', 'pending')->count(),
            'pending_outbound' => OutboundShipment::where('status', 'pending')->count(),
            'total_customers' => Customer::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
