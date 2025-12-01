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

        if (! $trackingNumber) {
            return view('packages.track', [
                'packages' => null,
                'inboundShipment' => null,
                'outboundShipment' => null,
                'trackingNumber' => null,
            ]);
        }

        // Try to find inbound shipment first
        $inboundShipment = \App\Models\InboundShipment::where('tracking_number', $trackingNumber)
            ->with(['customer', 'packages.product', 'packages.location'])
            ->first();

        // Try to find outbound shipment
        $outboundShipment = \App\Models\OutboundShipment::where('tracking_number', $trackingNumber)
            ->with(['customer', 'shippingZone', 'packages.product', 'packages.location'])
            ->first();

        $packages = collect();

        if ($inboundShipment) {
            $packages = $packages->merge($inboundShipment->packages);
        }

        if ($outboundShipment) {
            // Merge outbound packages, avoiding duplicates
            foreach ($outboundShipment->packages as $package) {
                if (!$packages->contains('id', $package->id)) {
                    $packages->push($package);
                }
            }
        }

        // If no shipment found, try to find package directly
        if ($packages->isEmpty()) {
            $package = Package::whereHas('inboundShipment', function ($query) use ($trackingNumber) {
                $query->where('tracking_number', $trackingNumber);
            })->orWhereHas('outboundShipment', function ($query) use ($trackingNumber) {
                $query->where('tracking_number', $trackingNumber);
            })->with(['inboundShipment.customer', 'outboundShipment.customer', 'product', 'location'])
                ->first();

            if ($package) {
                $packages = collect([$package]);
                if ($package->inboundShipment && !$inboundShipment) {
                    $inboundShipment = $package->inboundShipment;
                }
                if ($package->outboundShipment && !$outboundShipment) {
                    $outboundShipment = $package->outboundShipment;
                }
            }
        }

        return view('packages.track', [
            'packages' => $packages->isEmpty() ? null : $packages,
            'inboundShipment' => $inboundShipment,
            'outboundShipment' => $outboundShipment,
            'trackingNumber' => $trackingNumber,
        ]);
    }
}
