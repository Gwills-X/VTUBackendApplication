<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\NetworkPlanCategory;

return new class extends Migration
{
    public function up(): void
    {
        $plans = DB::table('available_data_plans')->get();

        foreach ($plans as $plan) {

            // Build expected network category name
            $networkName = strtolower($plan->network);

            // Get main category ID
            $planCategoryId = $plan->plan_category_id;

            // Find matching network plan category
            $networkPlanCategory = NetworkPlanCategory::where('plan_category_id', $planCategoryId)
                ->whereRaw('LOWER(name) LIKE ?', ["%{$networkName}%"])
                ->first();

            if ($networkPlanCategory) {
                DB::table('available_data_plans')
                    ->where('id', $plan->id)
                    ->update([
                        'network_plan_category_id' => $networkPlanCategory->id
                    ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('available_data_plans')
            ->update(['network_plan_category_id' => null]);
    }
};
