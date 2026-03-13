<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class VtuWebhookController extends Controller
{
    public function handle(Request $request)
{
    $reference = $request->input('reference');
    $status = $request->input('status');

    $transaction = Transaction::where('reference', $reference)->first();

    if (!$transaction) {
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    if ($transaction->status !== 'success') {

        $transaction->update(['status' => $status]);

        if ($status === 'failed') {
            $transaction->user->wallet
                ->increment('balance', $transaction->amount);
        }
    }

    return response()->json(['received' => true]);
}
}
