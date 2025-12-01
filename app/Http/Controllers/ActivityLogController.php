<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }

        $activityLogs = $query->paginate(20)->withQueryString();

        // Get filter options
        $users = User::orderBy('name')->get();
        $actions = ActivityLog::distinct()->pluck('action')->sort()->values();
        $modelTypes = ActivityLog::distinct()->pluck('model_type')->sort()->values();

        // Get model type labels (remove namespace)
        $modelTypeLabels = $modelTypes->mapWithKeys(function ($type) {
            $label = class_basename($type);

            return [$type => $label];
        });

        return view('activity-logs.index', compact('activityLogs', 'users', 'actions', 'modelTypes', 'modelTypeLabels'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');

        // Try to load the related model if it still exists
        $relatedModel = null;
        $modelUrl = null;
        if ($activityLog->model_type && $activityLog->model_id) {
            try {
                $modelClass = $activityLog->model_type;
                if (class_exists($modelClass)) {
                    $relatedModel = $modelClass::find($activityLog->model_id);
                    if ($relatedModel) {
                        $modelUrl = $this->getModelUrl($activityLog->model_type, $activityLog->model_id);
                    }
                }
            } catch (\Exception $e) {
                // Model might be deleted or class doesn't exist
            }
        }

        return view('activity-logs.show', compact('activityLog', 'relatedModel', 'modelUrl'));
    }

    /**
     * Get the URL for a model based on its type.
     */
    private function getModelUrl(string $modelType, int $modelId): ?string
    {
        $modelName = class_basename($modelType);

        $routes = [
            'Product' => 'products.show',
            'Customer' => 'customers.show',
            'Warehouse' => 'warehouses.show',
            'InboundShipment' => 'inbound-shipments.show',
            'OutboundShipment' => 'outbound-shipments.show',
            'Package' => 'packages.show',
            'Category' => 'categories.show',
            'ShippingZone' => 'shipping-zones.show',
            'User' => 'users.show',
        ];

        if (isset($routes[$modelName])) {
            try {
                return route($routes[$modelName], $modelId);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}
