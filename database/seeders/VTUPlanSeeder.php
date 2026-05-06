<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableDataPlan;
use App\Models\PlanCategory;
use App\Models\NetworkPlanCategory;

class VTUPlanSeeder extends Seeder
{
    public function run()
    {
        // --- MTN SECTION ---
        $this->seedNetwork('mtn', 1, [
            'PROMO' => [
                ['id' => 621, 'size' => '1 GB', 'amount' => 350.00, 'validity' => '1 Month'],
            ],
            'Data share' => [
                ['id' => 652, 'size' => '500 MB', 'amount' => 379.00, 'validity' => '7 days'],
                ['id' => 5,   'size' => '1 GB',   'amount' => 599.00, 'validity' => 'monthly'],
                ['id' => 315, 'size' => '1 GB',   'amount' => 549.00, 'validity' => '7 days'],
                ['id' => 316, 'size' => '2 GB',   'amount' => 1340.00, 'validity' => 'monthly'],
                ['id' => 317, 'size' => '3 GB',   'amount' => 2010.00, 'validity' => 'monthly'],
                ['id' => 653, 'size' => '5 GB',   'amount' => 3250.00, 'validity' => 'monthly'],
            ],
            'Gifting' => [
                ['id' => 540, 'size' => '750 MB', 'amount' => 446.00, 'validity' => '3 days'],
                ['id' => 650, 'size' => '800 GB', 'amount' => 123750.00, 'validity' => '1 year'],
            ],
            'MTN AWOOF' => [
                ['id' => 616, 'size' => '1 GB', 'amount' => 549.00, 'validity' => '1 day'],
            ]
        ]);

        // --- AIRTEL SECTION (Gifting Only) ---
     // --- AIRTEL SECTION (Full Gifting List) ---
$this->seedNetwork('airtel', 2, [
    'GIFTING' => [
        ['id' => 661, 'size' => '75 MB', 'amount' => 74.25, 'validity' => '1 day'],
        ['id' => 164, 'size' => '200 MB', 'amount' => 198.00, 'validity' => '2 days'],
        ['id' => 579, 'size' => '300 MB', 'amount' => 297.00, 'validity' => '2-Days'],
        ['id' => 644, 'size' => '1 GB',   'amount' => 792.00, 'validity' => '7 days'],
        ['id' => 648, 'size' => '1.5 GB', 'amount' => 990.00, 'validity' => '7 days'],
        ['id' => 326, 'size' => '2 GB',   'amount' => 594.00, 'validity' => '2 days'],
        ['id' => 633, 'size' => '2 GB',   'amount' => 1485.00, 'validity' => '30 days'],
        ['id' => 580, 'size' => '3 GB',   'amount' => 1980.00, 'validity' => '30 days'],
        ['id' => 663, 'size' => '3.2 GB', 'amount' => 990.00, 'validity' => '2 days'],
        ['id' => 634, 'size' => '4 GB',   'amount' => 2475.00, 'validity' => '30 days'],
        ['id' => 664, 'size' => '5 GB',   'amount' => 1485.00, 'validity' => '2-Days'],
        ['id' => 577, 'size' => '6 GB',   'amount' => 2475.00, 'validity' => '7 days'],
        ['id' => 581, 'size' => '8 GB',   'amount' => 2970.00, 'validity' => '30 days'],
        ['id' => 665, 'size' => '10 GB',  'amount' => 3960.00, 'validity' => 'Monthly'],
        ['id' => 583, 'size' => '13 GB',  'amount' => 4950.00, 'validity' => '30 days'],
        ['id' => 632, 'size' => '18 GB',  'amount' => 4850.00, 'validity' => '7 days'],
        ['id' => 666, 'size' => '25 GB',  'amount' => 7920.00, 'validity' => '30 days'],
        ['id' => 588, 'size' => '35 GB',  'amount' => 9990.00, 'validity' => '30 DAYS'],
        ['id' => 585, 'size' => '60 GB',  'amount' => 14850.00, 'validity' => '30 days'],
        ['id' => 651, 'size' => '100 GB', 'amount' => 19800.00, 'validity' => '30 days'],
        ['id' => 667, 'size' => '160 GB', 'amount' => 29700.00, 'validity' => 'Monthly'],
        ['id' => 668, 'size' => '300 GB', 'amount' => 49500.00, 'validity' => '90 days'],
        ['id' => 669, 'size' => '350 GB', 'amount' => 59400.00, 'validity' => 'Monthly'],
    ]
]);
        // --- GLO SECTION ---
        // Using Network ID 3 for Glo based on standard VTU sequencing
        $this->seedNetwork('glo', 3, [
            'CORPORATE' => [
                ['id' => 187, 'size' => '1 GB', 'amount' => 300.00, 'validity' => '3 days'],
                ['id' => 192, 'size' => '3 GB', 'amount' => 900.00, 'validity' => '3 days'],
                ['id' => 342, 'size' => '1 GB', 'amount' => 385.00, 'validity' => 'weekly'],
                ['id' => 180, 'size' => '5 GB', 'amount' => 1925.00, 'validity' => 'weekly'],
                ['id' => 349, 'size' => '5 GB', 'amount' => 1500.00, 'validity' => '3 days'],
                ['id' => 181, 'size' => '3 GB', 'amount' => 1155.00, 'validity' => 'weekly'],
            ],
            'SME' => [
                ['id' => 37, 'size' => '200 MB', 'amount' => 90.00, 'validity' => 'Monthly'],
                ['id' => 38, 'size' => '500 MB', 'amount' => 218.00, 'validity' => 'Monthly'],
                ['id' => 39, 'size' => '1 GB',   'amount' => 435.00, 'validity' => 'Monthly'],
                ['id' => 40, 'size' => '2 GB',   'amount' => 870.00, 'validity' => 'Monthly'],
                ['id' => 41, 'size' => '3 GB',   'amount' => 1305.00, 'validity' => 'Monthly'],
                ['id' => 42, 'size' => '5 GB',   'amount' => 2175.00, 'validity' => 'Monthly'],
                ['id' => 43, 'size' => '10 GB',  'amount' => 4350.00, 'validity' => 'Monthly'],
            ],
            'AWOOF' => [
                ['id' => 356, 'size' => '1.5 GB', 'amount' => 294.00, 'validity' => '2 days'],
                ['id' => 357, 'size' => '2.5 GB', 'amount' => 490.00, 'validity' => '2 days'],
                ['id' => 358, 'size' => '10 GB',  'amount' => 1960.00, 'validity' => '7 days'],
            ]
        ]);

        $this->command->info("MTN, Airtel, and Glo plans seeded successfully!");
    }

    private function seedNetwork($networkName, $networkCode, $data)
    {
        foreach ($data as $typeName => $plans) {
            $category = PlanCategory::firstOrCreate(['name' => $typeName], ['active' => 1]);

            $netCat = NetworkPlanCategory::firstOrCreate([
                'name' => strtoupper($networkName) . ' ' . $typeName,
                'plan_category_id' => $category->id
            ], ['active' => 1]);

            foreach ($plans as $plan) {
                AvailableDataPlan::updateOrCreate(
                    ['network' => $networkName, 'plan_id' => $plan['id']],
                    [
                        'network_code' => $networkCode,
                        'data' => $plan['size'],
                        'price' => $plan['amount'],
                        'validity' => $plan['validity'],
                        'active' => 1,
                        'plan_category_id' => $category->id,
                        'network_plan_category_id' => $netCat->id,
                    ]
                );
            }
        }
    }
}
