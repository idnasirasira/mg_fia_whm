<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'location'])
            ->latest()
            ->paginate(15);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $warehouses = Warehouse::where('status', 'active')->get();

        return view('products.create', compact('categories', 'warehouses'));
    }

    /**
     * Create product from package data.
     */
    public function createFromPackage(Package $package)
    {
        $categories = Category::all();
        $warehouses = Warehouse::where('status', 'active')->get();

        // Pre-fill data from package
        $packageData = [
            'name' => $package->product ? $package->product->name : 'Product from Package #' . $package->id,
            'weight' => $package->weight,
            'dimensions' => $package->dimensions,
            'value' => $package->value,
            'location_id' => $package->location_id,
            'stock_quantity' => $package->quantity,
        ];

        return view('products.create', compact('categories', 'warehouses', 'packageData', 'package'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'location_id' => 'nullable|exists:warehouses,id',
            'package_id' => 'nullable|exists:packages,id',
        ]);

        $product = Product::create($validated);

        // If created from package, update package with product_id
        if ($request->has('package_id') && $request->package_id) {
            $package = Package::find($request->package_id);
            if ($package && !$package->product_id) {
                $package->update(['product_id' => $product->id]);

                // Update stock if package is stored
                if ($package->status === 'stored' && $package->product) {
                    $package->product->increment('stock_quantity', $package->quantity);
                }

                ActivityLog::log('updated', $package, 'Package #' . $package->id . ' assigned to product: ' . $product->name);
            }
        }

        ActivityLog::log('created', $product, 'Product created: ' . $product->name);

        $redirectRoute = $request->has('package_id') && $request->package_id
            ? route('packages.show', $request->package_id)
            : route('products.index');

        return redirect($redirectRoute)
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'location', 'packages']);

        ActivityLog::log('viewed', $product, 'Product viewed: ' . $product->name);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $warehouses = Warehouse::where('status', 'active')->get();

        return view('products.edit', compact('product', 'categories', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'location_id' => 'nullable|exists:warehouses,id',
        ]);

        $oldData = $product->toArray();
        $product->update($validated);
        $newData = $product->fresh()->toArray();

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

        ActivityLog::log('updated', $product, 'Product updated: ' . $product->name, $changes);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $productName = $product->name;
        $product->delete();

        ActivityLog::log('deleted', $product, 'Product deleted: ' . $productName);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
