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
                             ->paginate(20);

        $wallet = $user->wallet;

        return response()->json([
            'status' => true,
            'balance' => $wallet?->balance ?? 0,
            'data' => $transactions
        ]);
    }



}
