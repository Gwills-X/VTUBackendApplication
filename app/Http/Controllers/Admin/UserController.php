<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Ensure only admins can access this controller
     */


    /**
     * -----------------------------------------
     * GET ALL USERS (ADMIN ONLY)
     * -----------------------------------------
     */
    public function index(Request $request)
{
    $query = User::with('wallet');

    // Search
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%");
        });
    }

    // Filter by role
    if ($request->role === 'admin') {
        $query->where('is_admin', true);
    }

    if ($request->role === 'user') {
        $query->where('is_admin', false);
    }

    // Show deleted users
    if ($request->trashed === 'true') {
        $query->onlyTrashed();
    }

    $users = $query->latest()->paginate(20);

    return response()->json([
        'status' => true,
        'data' => $users
    ]);
}
    /**
     * -----------------------------------------
     * SHOW SINGLE USER (ADMIN ONLY)
     * Includes wallet + paginated transactions
     * -----------------------------------------
     */
    public function show($id)
    {
        $user = User::with('wallet')->findOrFail($id);

        $transactions = $user->transactions()
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user,
                'wallet' => $user->wallet,
                'transactions' => $transactions
            ]
        ]);
    }

    /**
     * -----------------------------------------
     * UPDATE USER (ADMIN ONLY)
     * -----------------------------------------
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|min:3',
            'email'    => 'required|email|unique:users,email,' . $id,
            'is_admin' => 'boolean',
        ]);

        $admin = $request->user();
        $user  = User::findOrFail($id);

        // Prevent modifying another admin
        if ($user->is_admin && $admin->id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot modify another admin'
            ], 403);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Only allow toggling admin if target is NOT admin
        if (!$user->is_admin && $request->has('is_admin')) {
            $user->is_admin = $request->is_admin;
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    /**
     * -----------------------------------------
     * DELETE USER (ADMIN ONLY)
     * -----------------------------------------
     */
    public function destroy(Request $request, $id)
{
    $admin = $request->user();
    $user = User::findOrFail($id);

    if ($admin->id === $user->id) {
        return response()->json([
            'status' => false,
            'message' => 'You cannot delete your own account'
        ], 403);
    }

    if ($user->is_admin) {
        return response()->json([
            'status' => false,
            'message' => 'You cannot delete another admin'
        ], 403);
    }

    $user->delete();

    return response()->json([
        'status' => true,
        'message' => 'User soft deleted'
    ]);
}

public function restore($id)
{
    $user = User::withTrashed()->findOrFail($id);

    $user->restore();

    return response()->json([
        'status' => true,
        'message' => 'User restored successfully'
    ]);
}
}
