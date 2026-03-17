<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VtuService;
use App\Models\ElectricityProvider;


class ElectricityController extends Controller
{
 protected $vtuService;
public function __construct(VtuService $vtuService){
$this->vtuService = $vtuService;
}

    // GET ALL ELECTRICITY PROVIDERS (for frontend dropdown)
    public function providers()
    {
        $providers = ElectricityProvider::latest()->where('status', true)->get();

        return response()->json([
            'status' => true,
            'data' => $providers
        ]);
    }

    // PURCHASE ELECTRICITY
    public function purchase(Request $request)
{
    $request->validate([
        'electricity_distributor_id' => 'required|exists:electricity_providers,id',
        'meter_number' => 'required|string',
        'meter_type' => 'required|in:prepaid,postpaid',
        'phone_number' => 'required|string',
        'amount' => 'required|numeric|min:500',
        'name' => 'required|string',
    ]);

    $user = $request->user();

    $result = $this->vtuService->buyElectricity($user, $request->all());

    if (!$result['status']) {
        return response()->json([
            'status' => false,
            'message' => $result['message']
        ], 400);
    }

    return response()->json([
        'status' => true,
        'message' => 'Electricity purchase processed',
        'data' => $result['transaction'],
        'balance' => $result['balance']
    ]);
}
}
