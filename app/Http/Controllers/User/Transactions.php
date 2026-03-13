<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Transactions extends Controller
{
      /**
     * GET AUTHENTICATED USER'S TRANSACTIONS
     */
    public function myTransactions(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()
                             ->latest()
                             ->paginate(10);

        $wallet = $user->wallet;

        return response()->json([
            'status' => true,
            'balance' => $wallet?->balance ?? 0,
            'data' => $transactions
        ]);
    }


    public function deleteTransaction(Request $request, $id)
    {
        $user = $request->user();

        $transaction = $user->transactions()->where("id", $id)->first();
        if(!$transaction){
            return response()->json([
                "status" => false,
                "message"=> "Transaction Not found"
            ], 404);
        }
        if ($transaction->status === 'success') {
            return response()->json([
                'status' => false,
                'message' => 'Approved transactions cannot be deleted.'
            ], 400);
        }

        $transaction->delete();

        return response()->json([
            'status' => true,
            'message' => 'Transaction deleted successfully.'
        ]);
    }
}
