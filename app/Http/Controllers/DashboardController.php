<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\InboundShipment;
use App\Models\OutboundShipment;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Basic Stats
        $stats = [
            'total_products' => Product::count(),
            'total_packages' => Package::count(),
            'total_customers' => Customer::count(),
            'total_inbound' => InboundShipment::count(),
            'total_outbound' => OutboundShipment::count(),
        ];

        // Status-based counts
        $statusStats = [
            'pending_inbound' => InboundShipment::where('status', 'pending')->count(),
            'received_inbound' => InboundShipment::where('status', 'received')->count(),
            'stored_inbound' => InboundShipment::where('status', 'stored')->count(),
            'pending_outbound' => OutboundShipment::where('status', 'pending')->count(),
            'packed_outbound' => OutboundShipment::where('status', 'packed')->count(),
            'shipped_outbound' => OutboundShipment::where('status', 'shipped')->orWhere('status', 'in_transit')->count(),
            'delivered_outbound' => OutboundShipment::where('status', 'delivered')->count(),
        ];

        // Package status counts
        $packageStats = [
            'stored' => Package::where('status', 'stored')->count(),
            'packed' => Package::where('status', 'packed')->count(),
            'shipped' => Package::where('status', 'shipped')->count(),
            'delivered' => Package::where('status', 'delivered')->count(),
        ];

        // Revenue & Value Stats
        $revenueStats = [
            'total_customs_value' => OutboundShipment::sum('customs_value') ?? 0,
            'total_shipping_cost' => OutboundShipment::sum('shipping_cost') ?? 0,
            'total_inventory_value' => Package::where('status', 'stored')->sum('value') ?? 0,
        ];

        // Recent Activities (last 10)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Recent Shipments
        $recentInbound = InboundShipment::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        $recentOutbound = OutboundShipment::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        // Monthly shipment trends (last 6 months)
        // Use SQLite-compatible date formatting
        $monthlyInbound = InboundShipment::select(
            DB::raw('strftime("%Y-%m", created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('strftime("%Y-%m", created_at)'))
            ->orderBy('month')
            ->get();

        $monthlyOutbound = OutboundShipment::select(
            DB::raw('strftime("%Y-%m", created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('strftime("%Y-%m", created_at)'))
            ->orderBy('month')
            ->get();

        // Low stock products (stock < 10)
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'statusStats',
            'packageStats',
            'revenueStats',
            'recentActivities',
            'recentInbound',
            'recentOutbound',
            'monthlyInbound',
            'monthlyOutbound',
            'lowStockProducts'
        ));
    }
}
