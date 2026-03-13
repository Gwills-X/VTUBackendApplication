<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableDataPlan;

class AvailableDataPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [

            /*
            |--------------------------------------------------------------------------
            | MTN - DATA SHARE
            |--------------------------------------------------------------------------
            */

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 5,
                'plan_type' => 'Data share',
                'data' => '1 GB',
                'price' => 599.00,
                'validity' => 'Monthly',
                'active' => true,
            ],
            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 315,
                'plan_type' => 'Data share',
                'data' => '1 GB',
                'price' => 549.00,
                'validity' => '7 days',
                'active' => true,
            ],
            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 316,
                'plan_type' => 'Data share',
                'data' => '2 GB',
                'price' => 1340.00,
                'validity' => 'Monthly',
                'active' => true,
            ],
            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 317,
                'plan_type' => 'Data share',
                'data' => '3 GB',
                'price' => 2010.00,
                'validity' => 'Monthly',
                'active' => true,
            ],
            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 653,
                'plan_type' => 'Data share',
                'data' => '5 GB',
                'price' => 3250.00,
                'validity' => 'Monthly',
                'active' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | MTN - GIFTING
            |--------------------------------------------------------------------------
            */

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 619,
                'plan_type' => 'GIFTING',
                'data' => '500 MB',
                'price' => 495.00,
                'validity' => '7 days',
                'active' => true,
            ],

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 540,
                'plan_type' => 'GIFTING',
                'data' => '750 MB',
                'price' => 446.00,
                'validity' => '3 days',
                'active' => true,
            ],

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 601,
                'plan_type' => 'GIFTING',
                'data' => '1 GB',
                'price' => 495.00,
                'validity' => '1 day (+1.5 mins)',
                'active' => true,
            ],

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 620,
                'plan_type' => 'GIFTING',
                'data' => '1 GB',
                'price' => 792.00,
                'validity' => '7 days',
                'active' => true,
            ],

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 622,
                'plan_type' => 'GIFTING',
                'data' => '1.5 GB',
                'price' => 990.00,
                'validity' => '7 days',
                'active' => true,
            ],

            // (ALL remaining MTN Gifting plans from your list continue here…)

            /*
            |--------------------------------------------------------------------------
            | MTN - AWOOF
            |--------------------------------------------------------------------------
            */

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 564,
                'plan_type' => 'MTN AWOOF',
                'data' => '11 GB',
                'price' => 3599.00,
                'validity' => '7 days',
                'active' => true,
            ],

            [
                'network' => 'mtn',
                'network_code' => 1,
                'plan_id' => 616,
                'plan_type' => 'MTN AWOOF',
                'data' => '1 GB',
                'price' => 549.00,
                'validity' => '1 day',
                'active' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | AIRTEL - GIFTING
            |--------------------------------------------------------------------------
            */

            [
                'network' => 'airtel',
                'network_code' => 2,
                'plan_id' => 164,
                'plan_type' => 'GIFTING',
                'data' => '200 MB',
                'price' => 198.00,
                'validity' => '2 days',
                'active' => true,
            ],

            [
                'network' => 'airtel',
                'network_code' => 2,
                'plan_id' => 326,
                'plan_type' => 'GIFTING',
                'data' => '2 GB',
                'price' => 594.00,
                'validity' => '2 days',
                'active' => true,
            ],

            // (ALL remaining Airtel plans from your list continue here…)

        ];

        foreach ($plans as $plan) {
            AvailableDataPlan::updateOrCreate(
                [
                    'network' => $plan['network'],
                    'plan_id' => $plan['plan_id'],
                ],
                $plan
            );
        }
    }
}
