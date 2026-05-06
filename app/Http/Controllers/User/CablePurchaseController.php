<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CableProvider;
use App\Models\CablePlan;

class CablePurchaseController extends Controller {
    // Get only active providers and their active plans
    public function getAvailableServices() {
        return CableProvider::where('is_active', true)
            ->with(['plans' => function($query) {
                $query->where('is_active', true);
            }])->get();
    }

    // Filter/Search plans by provider
    public function filterPlans(Request $request) {
        return CablePlan::where('cable_provider_id', $request->provider_id)
            ->where('plan_name', 'like', "%{$request->search}%")
            ->where('is_active', true)
            ->get();
    }

    // Buying logic
    public function purchase(Request $request) {
        $plan = CablePlan::findOrFail($request->plan_id);

        // 1. Verify user balance
        // 2. Call Topify API using $plan->plan_id and $request->smart_card_number
        // 3. Deduct balance and record transaction
    }
}
