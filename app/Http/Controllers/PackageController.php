<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::with(['inboundShipment', 'outboundShipment', 'product', 'location'])
            ->latest()
            ->paginate(15);

        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        $package->load(['inboundShipment.customer', 'outboundShipment.customer', 'product', 'location']);

        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,received,stored,packed,shipped,delivered',
            'location_id' => 'nullable|exists:warehouses,id',
        ]);

        $package->update($validated);

        return redirect()->route('packages.show', $package)
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /**
     * Track package by tracking number.
     */
    public function track(Request $request)
    {
        $trackingNumber = $request->get('tracking_number');

        if (!$trackingNumber) {
            return view('packages.track', ['package' => null, 'trackingNumber' => null]);
        }

        $package = Package::whereHas('inboundShipment', function ($query) use ($trackingNumber) {
            $query->where('tracking_number', $trackingNumber);
        })->orWhereHas('outboundShipment', function ($query) use ($trackingNumber) {
            $query->where('tracking_number', $trackingNumber);
        })->with(['inboundShipment.customer', 'outboundShipment.customer', 'product', 'location'])
            ->first();

        return view('packages.track', ['package' => $package, 'trackingNumber' => $trackingNumber]);
    }
}
