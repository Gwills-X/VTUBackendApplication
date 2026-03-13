<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableDataPlan;
use App\Models\PlanCategory;
use App\Models\NetworkPlanCategory;
use Illuminate\Http\Request;

class DataPlanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List Plans (with filters + optional trashed)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = AvailableDataPlan::with([
            'category',
            'networkCategory'
        ]);

        if ($request->plan_category_id) {
            $query->where('plan_category_id', $request->plan_category_id);
        }

        if ($request->network_plan_category_id) {
            $query->where('network_plan_category_id', $request->network_plan_category_id);
        }

        if ($request->plan_id) {
        $query->where('plan_id', 'like', '%' . $request->plan_id . '%');
    }

        if ($request->trashed === 'true') {
            $query->onlyTrashed();
        }

        return $query->latest()->paginate(20);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Network Plan Categories (For Filter Dropdown)
    |--------------------------------------------------------------------------
    */
    public function filterOptions()
{
    return NetworkPlanCategory::with('dataPlans')
        ->select('id', 'name', 'plan_category_id')
        ->orderBy('name')
        ->get();
}

    /*
    |--------------------------------------------------------------------------
    | Create Plan (Auto Create Categories If Not Exists)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'network' => 'required|string',
            'network_code' => 'required|integer',
            'plan_id' => 'required|integer|unique:available_data_plans,plan_id',
            'data' => 'required|string',
            'price' => 'required|numeric|min:0',
            'validity' => 'required|string',
            'plan_category_name' => 'required|string',
        ]);

        // 1️⃣ Create or get main category
        $planCategory = PlanCategory::firstOrCreate([
            'name' => ucfirst($validated['plan_category_name'])
        ]);

        // 2️⃣ Build network category name
        $networkCategoryName = ucfirst(strtolower($validated['network']))
            . ' ' . ucfirst($validated['plan_category_name']);

        // 3️⃣ Create or get network category
        $networkPlanCategory = NetworkPlanCategory::firstOrCreate(
            [
                'name' => $networkCategoryName
            ],
            [
                'plan_category_id' => $planCategory->id
            ]
        );

        // 4️⃣ Create plan
        $plan = AvailableDataPlan::create([
            'network' => strtolower($validated['network']),
            'network_code' => $validated['network_code'],
            'plan_id' => $validated['plan_id'],
            'data' => $validated['data'],
            'price' => $validated['price'],
            'validity' => $validated['validity'],
            'plan_category_id' => $planCategory->id,
            'network_plan_category_id' => $networkPlanCategory->id,
        ]);

        return response()->json([
            'message' => 'Plan created successfully',
            'data' => $plan
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Plan (Auto Handle Category Changes)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, AvailableDataPlan $dataPlan)
    {
        $validated = $request->validate([
            'network' => 'sometimes|string',
            'network_code' => 'sometimes|integer',
            'plan_id' => 'sometimes|integer|unique:available_data_plans,plan_id,' . $dataPlan->id,
            'data' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'validity' => 'sometimes|string',
            'plan_category_name' => 'sometimes|string',
        ]);

        // If category name is changing
        if (isset($validated['plan_category_name'])) {

            $planCategory = PlanCategory::firstOrCreate([
                'name' => ucfirst($validated['plan_category_name'])
            ]);

            $network = $validated['network'] ?? $dataPlan->network;

            $networkCategoryName = ucfirst(strtolower($network))
                . ' ' . ucfirst($validated['plan_category_name']);

            $networkPlanCategory = NetworkPlanCategory::firstOrCreate(
                [
                    'name' => $networkCategoryName
                ],
                [
                    'plan_category_id' => $planCategory->id
                ]
            );

            $validated['plan_category_id'] = $planCategory->id;
            $validated['network_plan_category_id'] = $networkPlanCategory->id;
        }

        $dataPlan->update($validated);

        return response()->json([
            'message' => 'Plan updated successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    */
    public function destroy(AvailableDataPlan $dataPlan)
    {
        $dataPlan->delete();

        return response()->json([
            'message' => 'Plan soft deleted'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Restore Soft Deleted Plan
    |--------------------------------------------------------------------------
    */
    public function restore($id)
    {
        $plan = AvailableDataPlan::withTrashed()->find($id);

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found'
            ], 404);
        }

        $plan->restore();

        return response()->json([
            'message' => 'Plan restored successfully'
        ]);
    }

    /**
 * Toggle the active status of a data plan
 */
public function toggleActive(AvailableDataPlan $dataPlan)
{
    $dataPlan->active = !$dataPlan->active;
    $dataPlan->save();

    return response()->json([
        'message' => $dataPlan->active
            ? 'Plan is now active'
            : 'Plan has been deactivated',
        'data' => $dataPlan
    ]);
}
}
