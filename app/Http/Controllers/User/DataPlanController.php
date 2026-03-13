<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AvailableDataPlan;
use Illuminate\Http\Request;

class DataPlanController extends Controller
{
    /**
     * Get all active data plans, optionally filtered by network or category
     */
    public function index(Request $request)
    {
        $query = AvailableDataPlan::with('category')->where('active', true);

        if ($request->has('network')) {
            $query->where('network_code', $request->network);
        }

        if ($request->has('plan_category_id')) {
            $query->where('plan_category_id', $request->plan_category_id);
        }

        return $query->orderBy('price', 'asc')->get();
    }

    /**
     * Get a single data plan details
     */
    public function show($id)
    {
        $plan = AvailableDataPlan::with('category')->findOrFail($id);
        return $plan;
    }
}
