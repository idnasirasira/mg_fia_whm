<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(15);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create($validated);

        ActivityLog::log('created', $customer, 'Customer created: ' . $customer->name);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['inboundShipments', 'outboundShipments']);

        ActivityLog::log('viewed', $customer, 'Customer viewed: ' . $customer->name);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,'.$customer->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
        ]);

        $oldData = $customer->toArray();
        $customer->update($validated);
        $newData = $customer->fresh()->toArray();

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

        ActivityLog::log('updated', $customer, 'Customer updated: ' . $customer->name, $changes);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customerName = $customer->name;
        $customer->delete();

        ActivityLog::log('deleted', $customer, 'Customer deleted: ' . $customerName);

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
