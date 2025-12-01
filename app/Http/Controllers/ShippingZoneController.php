<?php

namespace App\Http\Controllers;

use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingZones = ShippingZone::withCount('outboundShipments')
            ->latest()
            ->paginate(15);

        return view('shipping-zones.index', compact('shippingZones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipping-zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|array|min:1',
            'countries.*' => 'string|max:2',
            'estimated_delivery' => 'nullable|integer|min:1',
            'base_rate' => 'nullable|numeric|min:0',
            'per_kg_rate' => 'nullable|numeric|min:0',
        ]);

        // Build shipping rates structure
        $shippingRates = [
            'base_rate' => $validated['base_rate'] ?? 0,
            'per_kg_rate' => $validated['per_kg_rate'] ?? 0,
        ];

        ShippingZone::create([
            'name' => $validated['name'],
            'countries' => $validated['countries'],
            'shipping_rates' => $shippingRates,
            'estimated_delivery' => $validated['estimated_delivery'] ?? null,
        ]);

        return redirect()->route('shipping-zones.index')
            ->with('success', 'Shipping zone created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingZone $shippingZone)
    {
        $shippingZone->load('outboundShipments.customer');

        return view('shipping-zones.show', compact('shippingZone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingZone $shippingZone)
    {
        return view('shipping-zones.edit', compact('shippingZone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingZone $shippingZone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|array|min:1',
            'countries.*' => 'string|max:2',
            'estimated_delivery' => 'nullable|integer|min:1',
            'base_rate' => 'nullable|numeric|min:0',
            'per_kg_rate' => 'nullable|numeric|min:0',
        ]);

        // Build shipping rates structure
        $shippingRates = [
            'base_rate' => $validated['base_rate'] ?? 0,
            'per_kg_rate' => $validated['per_kg_rate'] ?? 0,
        ];

        $shippingZone->update([
            'name' => $validated['name'],
            'countries' => $validated['countries'],
            'shipping_rates' => $shippingRates,
            'estimated_delivery' => $validated['estimated_delivery'] ?? null,
        ]);

        return redirect()->route('shipping-zones.index')
            ->with('success', 'Shipping zone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();

        return redirect()->route('shipping-zones.index')
            ->with('success', 'Shipping zone deleted successfully.');
    }
}
