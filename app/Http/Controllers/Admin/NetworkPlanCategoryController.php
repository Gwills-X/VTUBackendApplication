<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanCategory;
use App\Models\NetworkPlanCategory;

class NetworkPlanCategoryController extends Controller
{
    public function index()
{
    $categories = PlanCategory::with(['networkCategories' => function ($query) {
        $query->orderBy('name');
    }])
    ->orderBy('name')
    ->get();

    return response()->json([
        'status' => true,
        'data' => $categories
    ]);
}
    /**
     * Create Plan Category + Network Plan Category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'network' => 'required|string',
            'plan_category_name' => 'required|string'
        ]);

        // 1️⃣ Create or get plan category
        $planCategory = PlanCategory::firstOrCreate([
            'name' => ucfirst(strtolower($validated['plan_category_name']))
        ]);

        // 2️⃣ Build network category name
        $networkCategoryName =
            ucfirst(strtolower($validated['network'])) . " " .
            ucfirst(strtolower($validated['plan_category_name']));

        // 3️⃣ Create network category
        $networkCategory = NetworkPlanCategory::firstOrCreate([
            'name' => $networkCategoryName,
            'plan_category_id' => $planCategory->id
        ]);

        return response()->json([
            "status" => true,
            "message" => "Network Plan Category created successfully",
            "data" => [
                "plan_category" => $planCategory,
                "network_category" => $networkCategory
            ]
        ]);
    }

public function togglePlanCategory($id)
{
    $category = PlanCategory::findOrFail($id);

    $category->active = !$category->active;
    $category->save();

    // 🔥 Cascade: disable all network categories under it
    if (!$category->active) {
        NetworkPlanCategory::where('plan_category_id', $category->id)
            ->update(['active' => false]);
    }

    return response()->json([
        "message" => "Plan category status updated",
        "active" => $category->active
    ]);
}

public function toggleNetworkCategory($id)
{
    $networkCategory = NetworkPlanCategory::findOrFail($id);

    $networkCategory->active = !$networkCategory->active;
    $networkCategory->save();

    return response()->json([
        "message" => "Network category status updated",
        "active" => $networkCategory->active
    ]);
}
}
