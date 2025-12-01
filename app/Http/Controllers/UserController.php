<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('warehouse')
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::where('status', 'active')->get();

        return view('users.create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,manager,staff'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'warehouse_id' => $validated['warehouse_id'] ?? null,
        ]);

        ActivityLog::log('created', $user, 'User created: ' . $user->name . ' (' . $user->email . ')');

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('warehouse');

        ActivityLog::log('viewed', $user, 'User viewed: ' . $user->name);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $warehouses = Warehouse::where('status', 'active')->get();

        return view('users.edit', compact('user', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,manager,staff'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'warehouse_id' => $validated['warehouse_id'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $oldData = $user->toArray();
        $user->update($updateData);
        $newData = $user->fresh()->toArray();

        // Track changes (exclude password)
        $changes = [];
        foreach ($updateData as $key => $value) {
            if ($key !== 'password' && isset($oldData[$key]) && $oldData[$key] != $value) {
                $changes[$key] = [
                    'old' => $oldData[$key],
                    'new' => $value,
                ];
            }
        }
        
        // Track password change separately if changed
        if (!empty($validated['password'])) {
            $changes['password'] = ['old' => '***', 'new' => '***'];
        }

        ActivityLog::log('updated', $user, 'User updated: ' . $user->name, $changes);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        ActivityLog::log('deleted', $user, 'User deleted: ' . $userName . ' (' . $userEmail . ')');

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
