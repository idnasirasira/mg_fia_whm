<?php

namespace App\Http\Controllers;

use App\Models\OutboundShipment;
use App\Models\Customer;
use App\Models\Package;
use App\Models\ShippingZone;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OutboundShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = OutboundShipment::with(['customer', 'packages', 'shippingZone'])
            ->latest()
            ->paginate(15);

        return view('outbound-shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $shippingZones = ShippingZone::all();
        $packages = Package::whereNull('outbound_shipment_id')
            ->whereIn('status', ['received', 'stored'])
            ->with('product', 'location', 'inboundShipment')
            ->latest()
            ->get();

        return view('outbound-shipments.create', compact('customers', 'shippingZones', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'shipping_date' => 'required|date',
            'carrier' => 'required|string|max:255',
            'destination_country' => 'required|string|max:255',
            'status' => 'required|string|in:pending,packed,shipped,in_transit,delivered,returned',
            'customs_value' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'shipping_zone_id' => 'nullable|exists:shipping_zones,id',
            'package_ids' => 'required|array|min:1',
            'package_ids.*' => 'exists:packages,id',
        ]);

        // Generate tracking number
        $trackingNumber = 'OUT-' . strtoupper(Str::random(10));

        $shipment = OutboundShipment::create([
            'tracking_number' => $trackingNumber,
            'customer_id' => $validated['customer_id'],
            'shipping_date' => $validated['shipping_date'],
            'carrier' => $validated['carrier'] ?? null,
            'destination_country' => $validated['destination_country'],
            'status' => $validated['status'],
            'customs_value' => $validated['customs_value'] ?? 0,
            'shipping_cost' => $validated['shipping_cost'] ?? 0,
            'shipping_zone_id' => $validated['shipping_zone_id'] ?? null,
        ]);

        // Update packages and decrease stock quantity
        $packages = Package::whereIn('id', $validated['package_ids'])->get();

        // Calculate total weight and customs value
        $totalWeight = $packages->sum('weight') ?? 0;
        $totalCustomsValue = $packages->sum('value') ?? 0;

        // Auto-calculate shipping cost if shipping zone is set
        $calculatedShippingCost = $validated['shipping_cost'] ?? 0;
        if ($shipment->shippingZone && $totalWeight > 0) {
            $rates = $shipment->shippingZone->shipping_rates;
            // Verify that rates is an array before accessing it
            if (is_array($rates) && isset($rates['base_rate']) && isset($rates['per_kg_rate'])) {
                $baseRate = $rates['base_rate'] ?? 0;
                $perKgRate = $rates['per_kg_rate'] ?? 0;
                $calculatedShippingCost = $baseRate + ($totalWeight * $perKgRate);

                // Update shipment with calculated cost
                $shipment->update(['shipping_cost' => $calculatedShippingCost]);
            }
        }

        // Update customs value if not provided
        if (empty($validated['customs_value']) && $totalCustomsValue > 0) {
            $shipment->update(['customs_value' => $totalCustomsValue]);
        }

        foreach ($packages as $package) {
            $package->update([
                'outbound_shipment_id' => $shipment->id,
                'status' => 'packed',
            ]);

            // Decrease product stock quantity
            if ($package->product_id) {
                $package->product->decrement('stock_quantity', $package->quantity);
            }
        }

        // Log activity
        ActivityLog::log('created', $shipment, 'Outbound shipment created');

        return redirect()->route('outbound-shipments.show', $shipment)
            ->with('success', 'Outbound shipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutboundShipment $outboundShipment)
    {
        $outboundShipment->load(['customer', 'packages.product', 'packages.location', 'shippingZone']);

        // Log activity
        ActivityLog::log('viewed', $outboundShipment, 'Outbound shipment viewed');

        return view('outbound-shipments.show', compact('outboundShipment'));
    }

    /**
     * Generate picking list for outbound shipment.
     */
    public function pickingList(OutboundShipment $outboundShipment)
    {
        $outboundShipment->load(['customer', 'packages.product', 'packages.location', 'shippingZone']);

        // Group packages by location for easier picking
        $packagesByLocation = $outboundShipment->packages->groupBy(function ($package) {
            return $package->location ? $package->location->name : 'No Location';
        });

        return view('outbound-shipments.picking-list', compact('outboundShipment', 'packagesByLocation'));
    }

    /**
     * Generate shipping label for outbound shipment.
     */
    public function shippingLabel(OutboundShipment $outboundShipment)
    {
        $outboundShipment->load(['customer', 'packages.product', 'shippingZone']);

        return view('outbound-shipments.shipping-label', compact('outboundShipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutboundShipment $outboundShipment)
    {
        $customers = Customer::all();
        $shippingZones = ShippingZone::all();
        $outboundShipment->load('packages');

        return view('outbound-shipments.edit', compact('outboundShipment', 'customers', 'shippingZones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutboundShipment $outboundShipment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'shipping_date' => 'required|date',
            'carrier' => 'required|string|max:255',
            'destination_country' => 'required|string|max:255',
            'status' => 'required|string|in:pending,packed,shipped,in_transit,delivered,returned',
            'customs_value' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'shipping_zone_id' => 'nullable|exists:shipping_zones,id',
        ]);

        $oldData = $outboundShipment->toArray();
        $outboundShipment->update($validated);
        $newData = $outboundShipment->fresh()->toArray();

        // Track changes
        $changes = [];
        foreach ($validated as $key => $value) {
            if (isset($oldData[$key]) && $oldData[$key] != $value) {
                $changes[$key] = [
                    'old' => $oldData[$key],
                    'new' => $value,
                ];
            }
        }

        // Update package status based on shipment status
        if ($validated['status'] === 'shipped') {
            $outboundShipment->packages()->update(['status' => 'shipped']);
        } elseif ($validated['status'] === 'delivered') {
            $outboundShipment->packages()->update(['status' => 'delivered']);
        }

        // Log activity
        ActivityLog::log('updated', $outboundShipment, 'Outbound shipment updated: ' . $outboundShipment->tracking_number, $changes);

        return redirect()->route('outbound-shipments.show', $outboundShipment)
            ->with('success', 'Outbound shipment updated successfully.');
    }

    /**
     * Update status only (quick action).
     */
    public function updateStatus(Request $request, OutboundShipment $outboundShipment)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,packed,shipped,in_transit,delivered,returned',
        ]);

        $oldStatus = $outboundShipment->status;
        $outboundShipment->update(['status' => $validated['status']]);

        // Update package status based on shipment status
        if ($validated['status'] === 'shipped') {
            $outboundShipment->packages()->update(['status' => 'shipped']);
        } elseif ($validated['status'] === 'delivered') {
            $outboundShipment->packages()->update(['status' => 'delivered']);
        } elseif ($validated['status'] === 'returned') {
            // When returned, restore packages to stored status and increment stock
            foreach ($outboundShipment->packages as $package) {
                $package->update([
                    'status' => 'stored',
                    'outbound_shipment_id' => null, // Release from outbound shipment
                ]);
                
                // Restore product stock quantity
                if ($package->product_id && $package->product) {
                    $package->product->increment('stock_quantity', $package->quantity);
                }
            }
        }

        // Log activity with status change
        $changes = [
            'status' => [
                'old' => $oldStatus,
                'new' => $validated['status'],
            ],
        ];
        ActivityLog::log('updated', $outboundShipment, 'Outbound shipment status updated: ' . $outboundShipment->tracking_number . ' (' . $oldStatus . ' → ' . $validated['status'] . ')', $changes);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $validated['status'],
                'status_label' => ucfirst(str_replace('_', ' ', $validated['status'])),
            ]);
        }

        return redirect()->route('outbound-shipments.index')
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutboundShipment $outboundShipment)
    {
        $trackingNumber = $outboundShipment->tracking_number;
        
        // Restore stock quantity and release packages
        foreach ($outboundShipment->packages as $package) {
            // Restore product stock quantity
            if ($package->product_id) {
                $package->product->increment('stock_quantity', $package->quantity);
            }

            $package->update([
                'outbound_shipment_id' => null,
                'status' => 'stored',
            ]);
        }

        $outboundShipment->delete();

        ActivityLog::log('deleted', $outboundShipment, 'Outbound shipment deleted: ' . $trackingNumber);

        return redirect()->route('outbound-shipments.index')
            ->with('success', 'Outbound shipment deleted successfully.');
    }
}
