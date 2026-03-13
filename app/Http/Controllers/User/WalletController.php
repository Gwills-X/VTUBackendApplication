<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;

class WalletController extends Controller
{
    /**
     * -----------------------------------------
     * FUND WALLET
     * -----------------------------------------
     * Adds money to the user's wallet.
     * Creates a transaction record with type 'wallet_fund'.
     */
    public function fund(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = $request->user();

        // Auto-create wallet if missing
        $wallet = $user->wallet ?? Wallet::create([
            'user_id' => $user->id,
            'balance' => 0
        ]);

        // Use transaction to ensure consistency
        DB::transaction(function () use ($wallet, $user, $request, &$transaction) {
            // Add amount to wallet
            $wallet->balance += $request->amount;
            $wallet->save();

            // Record transaction
            $transaction = Transaction::create([
                'user_id'   => $user->id,
                'type'      => 'wallet_fund',
                'amount'    => $request->amount,
                'status'    => 'pending', // Pending for admin approval
                'reference' => uniqid('TXN_'),
            ]);
        });

        return response()->json([
            'status'         => true,
            'message'        => 'Wallet fund created. Pending approval.',
            'wallet_balance' => $wallet->balance,
            'transaction'    => $transaction
        ], 200);
    }

    /**
     * -----------------------------------------
     * GET WALLET BALANCE
     * -----------------------------------------
     */
    public function balance(Request $request)
    {
        $wallet = $request->user()->wallet ?? Wallet::create([
            'user_id' => $request->user()->id,
            'balance' => 0
        ]);

        return response()->json([
            'status'  => true,
            'balance' => $wallet->balance
        ], 200);
    }
}
