<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NetworkPlanCategory;
use App\Models\PlanCategory;

class NetworkPlanCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Get main categories
        $dataShare = PlanCategory::where('name', 'Data Share')->first();
        $gifting = PlanCategory::where('name', 'Gifting')->first();
        $awoof = PlanCategory::where('name', 'MTN Awoof')->first();

        if (!$dataShare || !$gifting) {
            return;
        }

        $networkCategories = [

            // ========================
            // DATA SHARE
            // ========================
            [
                'name' => 'MTN Data Share',
                'plan_category_id' => $dataShare->id,
            ],
            [
                'name' => 'Airtel Data Share',
                'plan_category_id' => $dataShare->id,
            ],
            [
                'name' => 'GLO Data Share',
                'plan_category_id' => $dataShare->id,
            ],
            [
                'name' => '9Mobile Data Share',
                'plan_category_id' => $dataShare->id,
            ],

            // ========================
            // GIFTING
            // ========================
            [
                'name' => 'MTN Gifting',
                'plan_category_id' => $gifting->id,
            ],
            [
                'name' => 'Airtel Gifting',
                'plan_category_id' => $gifting->id,
            ],
            [
                'name' => 'GLO Gifting',
                'plan_category_id' => $gifting->id,
            ],
            [
                'name' => '9Mobile Gifting',
                'plan_category_id' => $gifting->id,
            ],

            // ========================
            // MTN AWOOF (if exists)
            // ========================
            [
                'name' => 'MTN Awoof Special',
                'plan_category_id' => $awoof?->id,
            ],
        ];

        foreach ($networkCategories as $category) {
            if ($category['plan_category_id']) {
                NetworkPlanCategory::updateOrCreate(
                    ['name' => $category['name']],
                    $category
                );
            }
        }
    }
}
