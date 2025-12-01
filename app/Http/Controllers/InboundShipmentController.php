<?php

namespace App\Http\Controllers;

use App\Models\InboundShipment;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InboundShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = InboundShipment::with(['customer', 'packages'])
            ->latest()
            ->paginate(15);

        return view('inbound-shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $warehouses = Warehouse::where('status', 'active')->get();

        return view('inbound-shipments.create', compact('customers', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'received_date' => 'required|date',
            'status' => 'required|string|in:pending,received,inspected,stored,rejected',
            'notes' => 'nullable|string',
            'packages' => 'required|array|min:1',
            'packages.*.product_id' => 'nullable|exists:products,id',
            'packages.*.quantity' => 'required|integer|min:1',
            'packages.*.weight' => 'nullable|numeric|min:0',
            'packages.*.dimensions' => 'nullable|string',
            'packages.*.value' => 'nullable|numeric|min:0',
            'packages.*.location_id' => 'nullable|exists:warehouses,id',
            'packages.*.hs_code' => 'nullable|string|max:20',
            'packages.*.customs_description' => 'nullable|string|max:500',
        ]);

        // Generate tracking number
        $trackingNumber = 'INB-' . strtoupper(Str::random(10));

        $shipment = InboundShipment::create([
            'tracking_number' => $trackingNumber,
            'customer_id' => $validated['customer_id'],
            'received_date' => $validated['received_date'],
            'status' => $validated['status'],
            'total_items' => count($validated['packages']),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Create packages
        foreach ($validated['packages'] as $packageData) {
            // Set package status based on shipment status
            $packageStatus = 'received';
            if ($validated['status'] === 'stored') {
                $packageStatus = 'stored';
            } elseif ($validated['status'] === 'inspected') {
                $packageStatus = 'received';
            }

            // Build customs info
            $customsInfo = null;
            if (!empty($packageData['hs_code']) || !empty($packageData['customs_description'])) {
                $customsInfo = [
                    'hs_code' => $packageData['hs_code'] ?? null,
                    'description' => $packageData['customs_description'] ?? null,
                ];
            }

            $package = Package::create([
                'inbound_shipment_id' => $shipment->id,
                'product_id' => $packageData['product_id'] ?? null,
                'quantity' => $packageData['quantity'],
                'weight' => $packageData['weight'] ?? null,
                'dimensions' => $packageData['dimensions'] ?? null,
                'value' => $packageData['value'] ?? 0,
                'status' => $packageStatus,
                'location_id' => $packageData['location_id'] ?? null,
                'customs_info' => $customsInfo,
            ]);

            // Update product stock quantity if product exists
            if ($package->product_id && $validated['status'] === 'stored' && $package->product) {
                $package->product->increment('stock_quantity', $package->quantity);
            }
        }

        // Log activity
        ActivityLog::log('created', $shipment, 'Inbound shipment created');

        return redirect()->route('inbound-shipments.show', $shipment)
            ->with('success', 'Inbound shipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InboundShipment $inboundShipment)
    {
        $inboundShipment->load(['customer', 'packages.product', 'packages.location']);

        return view('inbound-shipments.show', compact('inboundShipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InboundShipment $inboundShipment)
    {
        $customers = Customer::all();
        $warehouses = Warehouse::where('status', 'active')->get();
        $inboundShipment->load('packages');

        return view('inbound-shipments.edit', compact('inboundShipment', 'customers', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InboundShipment $inboundShipment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'received_date' => 'required|date',
            'status' => 'required|string|in:pending,received,inspected,stored,rejected',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $inboundShipment->status;
        $inboundShipment->update($validated);

        // Update package status based on shipment status
        if ($validated['status'] === 'stored') {
            $inboundShipment->packages()->update(['status' => 'stored']);

            // Update stock quantity if status changed to stored
            if ($oldStatus !== 'stored') {
                foreach ($inboundShipment->packages as $package) {
                    if ($package->product_id) {
                        $package->product->increment('stock_quantity', $package->quantity);
                    }
                }
            }
        } elseif ($validated['status'] === 'inspected') {
            $inboundShipment->packages()->update(['status' => 'received']);
        } elseif ($validated['status'] === 'rejected') {
            $inboundShipment->packages()->update(['status' => 'pending']);

            // Decrease stock if previously stored
            if ($oldStatus === 'stored') {
                foreach ($inboundShipment->packages as $package) {
                    if ($package->product_id) {
                        $package->product->decrement('stock_quantity', $package->quantity);
                    }
                }
            }
        }

        return redirect()->route('inbound-shipments.show', $inboundShipment)
            ->with('success', 'Inbound shipment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InboundShipment $inboundShipment)
    {
        $inboundShipment->delete();

        return redirect()->route('inbound-shipments.index')
            ->with('success', 'Inbound shipment deleted successfully.');
    }
}
