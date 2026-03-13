<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    /**
     * -----------------------------------------
     * GET ALL WALLETS (ADMIN)
     * -----------------------------------------
     */
    public function index()
    {
        $wallets = Wallet::with('user')
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $wallets
        ]);
    }

    /**
     * -----------------------------------------
     * SHOW SINGLE USER WALLET
     * -----------------------------------------
     */
    public function show($user_id)
    {
        $user = User::with('wallet')->findOrFail($user_id);

        return response()->json([
            'status' => true,
            'wallet' => $user->wallet
        ]);
    }

    /**
     * -----------------------------------------
     * CREDIT USER WALLET (ADMIN MANUAL FUNDING)
     * -----------------------------------------
     */
    public function credit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1'
        ]);

        DB::beginTransaction();

        try {

            $user = User::with('wallet')->findOrFail($request->user_id);

            if (!$user->wallet) {
                throw new \Exception("User wallet not found.");
            }

            // Increase wallet balance
            $user->wallet->increment('balance', $request->amount);

            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'credit',
                'status' => 'success',
                'reference' => uniqid('admin_credit_')
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Wallet credited successfully',
                'data' => $transaction
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Wallet credit failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * -----------------------------------------
     * DEBIT USER WALLET (ADMIN)
     * -----------------------------------------
     */
    public function debit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1'
        ]);

        DB::beginTransaction();

        try {

            $user = User::with('wallet')->findOrFail($request->user_id);

            if (!$user->wallet) {
                throw new \Exception("User wallet not found.");
            }

            if ($user->wallet->balance < $request->amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient wallet balance'
                ], 400);
            }

            // Decrease wallet balance
            $user->wallet->decrement('balance', $request->amount);

            // Record transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'debit',
                'status' => 'success',
                'reference' => uniqid('admin_debit_')
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Wallet debited successfully',
                'data' => $transaction
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Wallet debit failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * -----------------------------------------
     * VIEW WALLET TRANSACTIONS
     * -----------------------------------------
     */
    public function transactions($user_id)
    {
        $user = User::findOrFail($user_id);

        $transactions = $user->transactions()
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $transactions
        ]);
    }
}
