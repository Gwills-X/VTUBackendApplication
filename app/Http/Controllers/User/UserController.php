<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * -----------------------------------------
     * SHOW LOGGED-IN USER PROFILE
     * -----------------------------------------
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load(['wallet', 'transactions']);

        return response()->json([
            'status' => true,
            'data'   => $user
        ], 200);
    }


    public function setTransactionPin(Request $request)
{
    $user = $request->user();

    // If PIN already exists, block setup
    if ($user->transaction_pin) {
        return response()->json([
            'status' => false,
            'message' => 'Transaction PIN already set. You can only update it.'
        ], 400);
    }

    // Validate input
    $request->validate([
        'pin' => 'required|digits:4|confirmed',
        "pin_confirmation" =>"required|digits:4"
    ]);

    // Save hashed PIN
    $user->transaction_pin = Hash::make($request->pin);
    $user->save();

    return response()->json([
        'status' => true,
        'message' => 'Transaction PIN created successfully'
    ]);
}

    /**
     * -----------------------------------------
     * UPDATE NAME ONLY
     * -----------------------------------------
     */
    public function updateName(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'new_name' => 'required|string|min:3|max:255',
            "current_password"=>'required|string'
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Password is incorrect'
            ], 400);
        }

        $user->name = $request->new_name;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Name updated successfully',
            'data'    => $user
        ]);
    }

    /**
     * -----------------------------------------
     * UPDATE EMAIL ONLY
     * Requires previous email and password verification
     * -----------------------------------------
     */
    public function updateEmail(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_email' => 'required|email',
            'current_password'      => 'required|string',
            'new_email'     => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Verify current email
        if ($request->current_email !== $user->email) {
            return response()->json([
                'status'  => false,
                'message' => 'Current email does not match our records'
            ], 400);
        }

        // Verify password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Password is incorrect'
            ], 400);
        }

        $user->email = $request->new_email;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Email updated successfully',
            'data'    => $user
        ]);
    }

    /**
     * -----------------------------------------
     * UPDATE PASSWORD ONLY
     * Requires previous password verification
     * -----------------------------------------
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed', // new_password_confirmation required
            "new_password_confirmation"=>"required|string"
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully',
        ]);
    }

    /**
     * -----------------------------------------
     * DELETE OWN ACCOUNT
     * -----------------------------------------
     */
    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        DB::beginTransaction();

        try {
            if ($user->wallet) {
                $user->wallet->delete();
            }

            $user->transactions()->delete();
            $user->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Account deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete account',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
