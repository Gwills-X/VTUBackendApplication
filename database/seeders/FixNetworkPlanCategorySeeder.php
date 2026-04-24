<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableDataPlan;
use App\Models\PlanCategory;
use App\Models\NetworkPlanCategory;

class FixNetworkPlanCategorySeeder extends Seeder
{
    public function run()
    {
        $plans = AvailableDataPlan::all();

        foreach ($plans as $plan) {

            // Get Plan Category
            $category = PlanCategory::find($plan->plan_category_id);

            if (!$category) {
                continue;
            }

            // Build expected network category name
            $networkName = ucfirst(strtolower($plan->network)); // mtn → MTN
            $categoryName = ucfirst($category->name); // gifting → Gifting

            $fullName = $networkName . ' ' . $categoryName;

            // Find matching network category
            $networkCategory = NetworkPlanCategory::where('name', $fullName)->first();

            if ($networkCategory) {
                $plan->update([
                    'network_plan_category_id' => $networkCategory->id
                ]);

                echo "Updated Plan ID {$plan->id} → {$fullName}\n";
            } else {
                echo "No match for Plan ID {$plan->id} → {$fullName}\n";
            }
        }

        echo "Done fixing network_plan_category_id.\n";
    }
}
