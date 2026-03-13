<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\VtuService;

use App\Models\DataPlan;
use App\Models\Network;

class TopupController extends Controller
{


    /**
     * BUY AIRTIME
     */
   public function buyAirtime(Request $request, VtuService $vtu)
{
    $request->validate([
        'amount'     => 'required|numeric|min:50',
        'number'     => 'required|string|min:10|max:15',
        'network_id' => 'required|exists:networks,id',
    ]);

    $network = Network::findOrFail($request->network_id);

    $response = $vtu->buyAirtime(
        $request->user(),
        $request->amount,
        $request->number,
        $network->id
    );

    return response()->json($response, $response['status'] ? 200 : 400);
}
    /**
     * BUY DATA
     */
    public function buyData(Request $request, VtuService $vtu)
{
    $request->validate([
        'data_plan_id' => 'required|exists:data_plans,plan_id',
        'phone'        => 'required|string|min:10|max:15',
    ]);

    $plan = DataPlan::where("plan_id",$request->data_plan_id)->firstOrFail();

    if (!$plan->active) {
        return response()->json([
            'status' => false,
            'message' => 'Selected data plan is unavailable.'
        ], 400);
    }

    $response = $vtu->buyData(
        $request->user(),
        $plan,
        $request->phone
    );

    return response()->json($response, $response['status'] ? 200 : 400);
}

    }
