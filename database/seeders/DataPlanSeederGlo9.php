<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPlan;

class DataPlanSeederGlo9 extends Seeder
{
    public function run()
    {
        $plans = [
            // ---------------- Glo (Network ID = 3) ----------------
            [3, 180, 'CORPORATE', 1925, '5 GB', 'Weekly'],
            [3, 181, 'CORPORATE', 1155, '3 GB', 'Weekly'],
            [3, 187, 'CORPORATE', 300, '1 GB', '3 days'],
            [3, 192, 'CORPORATE', 900, '3 GB', '3 days'],
            [3, 342, 'CORPORATE', 385, '1 GB', 'Weekly'],
            [3, 349, 'CORPORATE', 1500, '5 GB', '3 days'],

            [3, 129, 'GIFTING', 1980, '6.25 GB', '30 Days (3.25GB + 3GB Night)'],
            [3, 131, 'GIFTING', 2475, '7.5 GB', '30 Days (4.5GB + 3GB Night)'],
            [3, 133, 'GIFTING', 3960, '12.5 GB', '30 Days incl. 2GB Night'],
            [3, 135, 'GIFTING', 7920, '28 GB', '30 Days incl. 2GB Night'],
            [3, 137, 'GIFTING', 14850, '64 GB', '30 Days incl. 2GB Night'],
            [3, 138, 'GIFTING', 19800, '107 GB', '30 Days incl. 2GB Night'],
            [3, 670, 'GIFTING', 49.5, '45 MB', '1 day'],
            [3, 672, 'GIFTING', 742.5, '1.1 GB', '14 days'],
            [3, 673, 'GIFTING', 1980, '8.5 GB', '7 days incl. 2.5GB Night'],
            [3, 674, 'GIFTING', 4950, '20.5 GB', '7 days incl. 2GB Night'],
            [3, 675, 'GIFTING', 5940, '20.5 GB', '30 days incl. 2GB Night'],

            [3, 3, 'SME2', 899, '1.8 GB', '3 Days'],
            [3, 182, 'SME2', 350, '700 MB', '7 days'],
            [3, 188, 'SME2', 530, '2 GB', 'Monthly'],
            [3, 189, 'SME2', 530, '3 GB', 'Monthly'],
            [3, 190, 'SME2', 530, '500 MB', 'Monthly'],
            [3, 191, 'SME2', 230, '1 GB', 'Monthly'],
            [3, 193, 'SME2', 530, '3 GB', 'Monthly'],
            [3, 195, 'SME2', 4500, '10 GB', '30 Days'],
            [3, 348, 'SME2', 530, '2 GB', 'Monthly'],
            [3, 350, 'SME2', 530, '500 MB', 'Monthly'],
            [3, 351, 'SME2', 230, '1 GB', 'Monthly'],
            [3, 352, 'SME2', 530, '2 GB', 'Monthly'],
            [3, 353, 'SME2', 530, '3 GB', 'Monthly'],
            [3, 354, 'SME2', 530, '500 MB', 'Monthly'],
            [3, 356, 'SME2', 294, '1.5 GB', '2 days'],

            [3, 37, 'SME', 90, '200 MB', 'Monthly'],
            [3, 38, 'SME', 218, '500 MB', 'Monthly'],
            [3, 39, 'SME', 435, '1 GB', 'Monthly'],
            [3, 40, 'SME', 870, '2 GB', 'Monthly'],
            [3, 41, 'SME', 1305, '3 GB', 'Monthly'],
            [3, 42, 'SME', 2175, '5 GB', 'Monthly'],
            [3, 43, 'SME', 4350, '10 GB', 'Monthly'],

            [3, 355, 'AWOOF', 196, '750 MB', '1 day'],
            [3, 357, 'AWOOF', 490, '2.5 GB', '2 days'],
            [3, 358, 'AWOOF', 1960, '10 GB', '7 days'],

            // ---------------- 9Mobile (Network ID = 4) ----------------
            [4, 4, 'SME', 230, '1 GB', 'Monthly'],
            [4, 28, 'SME', 367, '2.5 GB', 'Monthly'],
            [4, 179, 'SME', 230, '1 GB', 'Monthly'],
            [4, 199, 'SME', 230, '1 GB', 'Monthly'],
            [4, 200, 'SME', 530, '2 GB', 'Monthly'],
            [4, 201, 'SME', 530, '3 GB', 'Monthly'],
            [4, 202, 'SME', 530, '500 MB', 'Monthly'],
            [4, 339, 'SME', 230, '1 GB', 'Monthly'],
            [4, 340, 'SME', 530, '2 GB', 'Monthly'],
            [4, 341, 'SME', 530, '3 GB', 'Monthly'],
            [4, 359, 'SME', 230, '1 GB', 'Monthly'],
            [4, 360, 'SME', 530, '2 GB', 'Monthly'],
            [4, 361, 'SME', 530, '3 GB', 'Monthly'],
            [4, 362, 'SME', 530, '500 MB', 'Monthly'],

            [4, 29, 'GIFTING', 447, '3 GB', 'Monthly'],
            [4, 203, 'GIFTING', 230, '1 GB', 'Monthly'],
            [4, 204, 'GIFTING', 530, '2 GB', 'Monthly'],
            [4, 205, 'GIFTING', 530, '3 GB', 'Monthly'],
            [4, 206, 'GIFTING', 530, '500 MB', 'Monthly'],
            [4, 363, 'GIFTING', 230, '1 GB', 'Monthly'],
            [4, 364, 'GIFTING', 530, '2 GB', 'Monthly'],
            [4, 365, 'GIFTING', 530, '3 GB', 'Monthly'],
            [4, 366, 'GIFTING', 530, '500 MB', 'Monthly'],

            [4, 20, 'SME2', 11, '10 MB', 'Monthly'],
            [4, 21, 'SME2', 16, '15 MB', 'Monthly'],
            [4, 22, 'SME2', 29, '25 MB', 'Monthly'],
            [4, 23, 'SME2', 49, '100 MB', 'Monthly'],
            [4, 31, 'SME2', 655, '4.5 GB', 'Monthly'],
            [4, 33, 'SME2', 1629, '11 GB', 'Monthly'],
            [4, 35, 'SME2', 5660, '40 GB', 'Monthly'],
            [4, 36, 'SME2', 7250, '50 GB', 'Monthly'],
            [4, 207, 'SME2', 230, '1 GB', 'Monthly'],
            [4, 208, 'SME2', 530, '2 GB', 'Monthly'],
            [4, 209, 'SME2', 530, '3 GB', 'Monthly'],
            [4, 210, 'SME2', 530, '500 MB', 'Monthly'],
            [4, 367, 'SME2', 230, '1 GB', 'Monthly'],
            [4, 368, 'SME2', 530, '2 GB', 'Monthly'],
            [4, 369, 'SME2', 530, '3 GB', 'Monthly'],
            [4, 370, 'SME2', 530, '500 MB', 'Monthly'],

            [4, 24, 'CORPORATE', 150, '500 MB', 'Monthly'],
            [4, 25, 'CORPORATE', 299, '1 GB', 'Monthly'],
            [4, 26, 'CORPORATE', 449, '1.5 GB', 'Monthly'],
            [4, 27, 'CORPORATE', 598, '2 GB', 'Monthly'],
            [4, 30, 'CORPORATE', 1196, '4 GB', 'Monthly'],
            [4, 32, 'CORPORATE', 2990, '10 GB', 'Monthly'],
            [4, 34, 'CORPORATE', 5980, '20 GB', 'Monthly'],
            [4, 565, 'CORPORATE', 1495, '5 GB', 'Monthly'],
            [4, 566, 'CORPORATE', 897, '3 GB', 'Monthly'],

            [4, 215, 'OTHER', 230, '1 GB', 'Monthly'],
            [4, 216, 'OTHER', 530, '2 GB', 'Monthly'],
            [4, 217, 'OTHER', 530, '3 GB', 'Monthly'],
            [4, 218, 'OTHER', 530, '500 MB', 'Monthly'],
            [4, 375, 'OTHER', 230, '1 GB', 'Monthly'],
            [4, 376, 'OTHER', 530, '2 GB', 'Monthly'],
            [4, 377, 'OTHER', 530, '3 GB', 'Monthly'],
            [4, 378, 'OTHER', 530, '500 MB', 'Monthly'],
        ];

        foreach ($plans as $plan) {
            DataPlan::create([
                'network_id' => $plan[0],
                'plan_id' => $plan[1],
                'plan_type' => $plan[2],
                'price' => $plan[3],
                'plan_name' => $plan[4],
                'validity' => $plan[5]
            ]);
        }
    }
}
