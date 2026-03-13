<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * -----------------------------------------
     * GET ALL TRANSACTIONS (ADMIN ONLY)
     * -----------------------------------------
     * Returns paginated transactions with user info
     */
    public function index()
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->paginate(20);
        $allTransactions= Transaction::all();
        return response()->json([
            'status' => true,
            'data' => $transactions,
            "allTransactions"=>$allTransactions
        ]);
    }

    /**
     * -----------------------------------------
     * SHOW A SINGLE TRANSACTION (ADMIN ONLY)
     * -----------------------------------------
     */
    public function show($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $transaction
        ]);
    }

    /**
     * -----------------------------------------
     * GET ALL TRANSACTIONS FOR A USER
     * -----------------------------------------
     */
    public function showUserTransaction($user_id)
    {
        $user = User::with(['wallet', 'transactions'])->findOrFail($user_id);

        return response()->json([
            'status' => true,
            'message' => 'User transactions fetched successfully',
            'data' => [
                'transactions' => $user->transactions,
            ]
        ], 200);
    }

    /**
     * -----------------------------------------
     * UPDATE TRANSACTION STATUS (ADMIN ONLY)
     * -----------------------------------------
     * Updates status of a transaction (pending → success/failed)
     * Automatically updates wallet if approved (success)
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate incoming status
        $request->validate([
            'status' => 'required|in:pending,success,failed',
        ]);

        $transaction = Transaction::with('user')->findOrFail($id);

        // Prevent double approval/rejection
        if ($transaction->status !== 'pending') {
            return response()->json([
                'status' => false,
                'message' => 'Transaction has already been processed',
                'data' => $transaction
            ], 400);
        }

        DB::transaction(function () use ($transaction, $request) {
            $transaction->status = $request->status;
            $transaction->save();

            // Only update wallet if transaction is approved
            if ($request->status === 'success') {
                $wallet = $transaction->user->wallet;
                $wallet->balance += $transaction->amount;
                $wallet->save();
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Transaction status updated successfully',
            'data' => $transaction
        ]);
    }



}
