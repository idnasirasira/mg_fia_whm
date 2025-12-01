<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\InboundShipmentsExport;
use App\Exports\OutboundShipmentsExport;
use App\Exports\ProductsExport;
use App\Models\Customer;
use App\Models\InboundShipment;
use App\Models\OutboundShipment;
use App\Models\Package;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display reports dashboard.
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Inventory Reports
        $inventoryStats = [
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
            'out_of_stock' => Product::where('stock_quantity', '<=', 0)->count(),
            'total_stock_value' => Product::sum(DB::raw('stock_quantity * value')),
        ];

        // Inbound Reports
        $inboundStats = [
            'today' => InboundShipment::whereDate('received_date', $today)->count(),
            'this_month' => InboundShipment::where('received_date', '>=', $thisMonth)->count(),
            'last_month' => InboundShipment::whereBetween('received_date', [$lastMonth, $lastMonthEnd])->count(),
            'pending' => InboundShipment::where('status', 'pending')->count(),
            'stored' => InboundShipment::where('status', 'stored')->count(),
        ];

        // Outbound Reports
        $outboundStats = [
            'today' => OutboundShipment::whereDate('shipping_date', $today)->count(),
            'this_month' => OutboundShipment::where('shipping_date', '>=', $thisMonth)->count(),
            'last_month' => OutboundShipment::whereBetween('shipping_date', [$lastMonth, $lastMonthEnd])->count(),
            'pending' => OutboundShipment::where('status', 'pending')->count(),
            'delivered' => OutboundShipment::where('status', 'delivered')->count(),
            'total_revenue' => OutboundShipment::where('status', 'delivered')->sum('shipping_cost'),
        ];

        // Package Reports
        $packageStats = [
            'total' => Package::count(),
            'stored' => Package::where('status', 'stored')->count(),
            'shipped' => Package::where('status', 'shipped')->count(),
            'delivered' => Package::where('status', 'delivered')->count(),
        ];

        // Top Customers
        $topCustomers = Customer::withCount('outboundShipments')
            ->orderBy('outbound_shipments_count', 'desc')
            ->limit(5)
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

        return view('reports.index', compact(
            'inventoryStats',
            'inboundStats',
            'outboundStats',
            'packageStats',
            'topCustomers',
            'recentInbound',
            'recentOutbound'
        ));
    }

    /**
     * Inventory report.
     */
    public function inventory()
    {
        $products = Product::with(['category', 'location'])
            ->orderBy('stock_quantity', 'asc')
            ->get();

        $lowStock = Product::where('stock_quantity', '<', 10)
            ->where('stock_quantity', '>', 0)
            ->with(['category', 'location'])
            ->get();

        $outOfStock = Product::where('stock_quantity', '<=', 0)
            ->with(['category', 'location'])
            ->get();

        return view('reports.inventory', compact('products', 'lowStock', 'outOfStock'));
    }

    /**
     * Shipping report.
     */
    public function shipping(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $inboundShipments = InboundShipment::with('customer')
            ->whereBetween('received_date', [$startDate, $endDate])
            ->latest()
            ->get();

        $outboundShipments = OutboundShipment::with('customer', 'shippingZone')
            ->whereBetween('shipping_date', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('reports.shipping', compact('inboundShipments', 'outboundShipments', 'startDate', 'endDate'));
    }

    /**
     * Export products to Excel.
     */
    public function exportProducts()
    {
        return Excel::download(new ProductsExport, 'products_'.date('Y-m-d_His').'.xlsx');
    }

    /**
     * Export customers to Excel.
     */
    public function exportCustomers()
    {
        return Excel::download(new CustomersExport, 'customers_'.date('Y-m-d_His').'.xlsx');
    }

    /**
     * Export inbound shipments to Excel.
     */
    public function exportInboundShipments()
    {
        return Excel::download(new InboundShipmentsExport, 'inbound_shipments_'.date('Y-m-d_His').'.xlsx');
    }

    /**
     * Export outbound shipments to Excel.
     */
    public function exportOutboundShipments()
    {
        return Excel::download(new OutboundShipmentsExport, 'outbound_shipments_'.date('Y-m-d_His').'.xlsx');
    }
}
