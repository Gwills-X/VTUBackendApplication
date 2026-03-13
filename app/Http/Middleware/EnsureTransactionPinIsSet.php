<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EnsureTransactionPinIsSet
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Allow funding wallet without PIN
        if ($request->is('api/user/wallet/fund')) {
            return $next($request);
        }

        // 1️⃣ Check if PIN is set
        if (!$user->transaction_pin) {
            return response()->json([
                'status' => false,
                'message' => 'Please set your transaction PIN before making transactions.'
            ], 403);
        }

        // 2️⃣ Check if user is locked
        if ($user->pin_locked_until && Carbon::now()->lt($user->pin_locked_until)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many failed attempts. Try again later.'
            ], 423);
        }

        // 3️⃣ Require PIN in request
        $enteredPin = $request->input('pin');

        if (!$enteredPin) {
            return response()->json([
                'status' => false,
                'message' => 'Transaction PIN is required.'
            ], 422);
        }

        // 4️⃣ Check if PIN matches (hashed comparison)
        if (!Hash::check($enteredPin, $user->transaction_pin)) {

            // Increase attempt count
            $user->increment('pin_attempts');

            // Lock after 3 wrong attempts
            if ($user->pin_attempts >= 3) {
                $user->pin_locked_until = Carbon::now()->addMinutes(5);
                $user->pin_attempts = 0;
            }

            $user->save();

            return response()->json([
                'status' => false,
                'message' => 'Invalid transaction PIN.'
            ], 401);
        }

        // 5️⃣ Reset attempts if correct
        $user->pin_attempts = 0;
        $user->pin_locked_until = null;
        $user->save();

        return $next($request);
    }
}
