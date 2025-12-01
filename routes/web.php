<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\InboundShipmentController;
use App\Http\Controllers\OutboundShipmentController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ShippingZoneController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;

// Public routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration (only for admin)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('role:admin');
Route::post('/register', [RegisterController::class, 'register'])->middleware('role:admin');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Customers
    Route::resource('customers', CustomerController::class);

    // Warehouses
    Route::resource('warehouses', WarehouseController::class);

    // Inbound Shipments
    Route::resource('inbound-shipments', InboundShipmentController::class);

    // Outbound Shipments
    Route::resource('outbound-shipments', OutboundShipmentController::class);
    Route::patch('/outbound-shipments/{outboundShipment}/status', [OutboundShipmentController::class, 'updateStatus'])->name('outbound-shipments.update-status');
    Route::get('/outbound-shipments/{outboundShipment}/picking-list', [OutboundShipmentController::class, 'pickingList'])->name('outbound-shipments.picking-list');
    Route::get('/outbound-shipments/{outboundShipment}/shipping-label', [OutboundShipmentController::class, 'shippingLabel'])->name('outbound-shipments.shipping-label');

    // Packages
    Route::resource('packages', PackageController::class);
    Route::get('/packages/track', [PackageController::class, 'track'])->name('packages.track');

    // Shipping Zones
    Route::resource('shipping-zones', ShippingZoneController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/shipping', [ReportController::class, 'shipping'])->name('reports.shipping');
    Route::get('/reports/export/products', [ReportController::class, 'exportProducts'])->name('reports.export.products');
    Route::get('/reports/export/customers', [ReportController::class, 'exportCustomers'])->name('reports.export.customers');
    Route::get('/reports/export/inbound-shipments', [ReportController::class, 'exportInboundShipments'])->name('reports.export.inbound-shipments');
    Route::get('/reports/export/outbound-shipments', [ReportController::class, 'exportOutboundShipments'])->name('reports.export.outbound-shipments');

    // Users (Admin & Manager only)
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    });
});
