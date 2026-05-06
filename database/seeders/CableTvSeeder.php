<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CableProvider;
use App\Models\CablePlan;

class CableTvSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Providers
        $gotv = CableProvider::create(['name' => 'GOtv', 'api_id' => '1', 'is_active' => true]);
        $dstv = CableProvider::create(['name' => 'DStv', 'api_id' => '2', 'is_active' => true]);
        $startimes = CableProvider::create(['name' => 'StarTimes', 'api_id' => '3', 'is_active' => true]);

        // 2. GOtv Plans (Filtered from Screenshots 315 & 316)
        $gotv_plans = [
            ['plan_name' => 'GOtv Smallie - monthly', 'plan_id' => '1', 'price' => 1900.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Jinja', 'plan_id' => '2', 'price' => 3900.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Supa Plus - monthly', 'plan_id' => '3', 'price' => 16800.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Jolli', 'plan_id' => '4', 'price' => 5800.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Max', 'plan_id' => '5', 'price' => 8500.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Supa - monthly', 'plan_id' => '6', 'price' => 11400.00, 'validity' => 'Monthly'],
            ['plan_name' => 'GOtv Smallie - quarterly', 'plan_id' => '45', 'price' => 5100.00, 'validity' => '3 Months'],
            ['plan_name' => 'GOtv Smallie - yearly', 'plan_id' => '46', 'price' => 15000.00, 'validity' => 'Yearly'],
        ];

        foreach ($gotv_plans as $plan) {
            $gotv->plans()->create($plan);
        }

        // 3. DStv Plans (Filtered from Screenshots 317 & 318)
        $dstv_plans = [
            ['plan_name' => 'DStv Compact + Asia', 'plan_id' => '7', 'price' => 33900.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Padi', 'plan_id' => '8', 'price' => 4400.00, 'validity' => 'Monthly'],
            ['plan_name' => 'ExtraView Access', 'plan_id' => '9', 'price' => 6000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Yanga', 'plan_id' => '10', 'price' => 6000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Padi + ExtraView', 'plan_id' => '11', 'price' => 10400.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Confam', 'plan_id' => '12', 'price' => 11000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Confam + ExtraView', 'plan_id' => '15', 'price' => 17000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Compact', 'plan_id' => '16', 'price' => 19000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Compact + Extra View', 'plan_id' => '17', 'price' => 25000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Compact Plus', 'plan_id' => '18', 'price' => 30000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'DStv Compact Plus + Extra View', 'plan_id' => '19', 'price' => 36000.00, 'validity' => 'Monthly'],
        ];

        foreach ($dstv_plans as $plan) {
            $dstv->plans()->create($plan);
        }

        // 4. StarTimes Plans (Filtered from Screenshots 319 & 320)
        $startimes_plans = [
            ['plan_name' => 'Nova (Antenna) - 600 Naira - 1 Week', 'plan_id' => '27', 'price' => 600.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Basic (Antenna) - 1250 Naira - 1 Week', 'plan_id' => '30', 'price' => 1250.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Smart (Dish) - 1,550 Naira - 1 Week', 'plan_id' => '31', 'price' => 1550.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Classic (Antenna) - 1900 Naira - 1 Week', 'plan_id' => '32', 'price' => 1900.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Nova (Dish) - 1900 Naira - 1 Month', 'plan_id' => '33', 'price' => 1900.00, 'validity' => 'Monthly'],
            ['plan_name' => 'Super (Dish) - 3000 Naira - 1 Week', 'plan_id' => '34', 'price' => 3000.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Classic (Antenna) - 5,500 Naira - 1 Month', 'plan_id' => '37', 'price' => 5500.00, 'validity' => 'Monthly'],
            ['plan_name' => 'Super (Dish) - 9,000 Naira - 1 Month', 'plan_id' => '38', 'price' => 9000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'Chinese (Dish) - 19,000 Naira - 1 Month', 'plan_id' => '81', 'price' => 19000.00, 'validity' => 'Monthly'],
            ['plan_name' => 'Special (Dish) - 2300 Naira - 1 Week', 'plan_id' => '83', 'price' => 2300.00, 'validity' => 'Weekly'],
            ['plan_name' => 'Special (Dish) - 6800 Naira - 1 Month', 'plan_id' => '84', 'price' => 6800.00, 'validity' => 'Monthly'],
            ['plan_name' => 'Nova (Dish) - 600 Naira - 1 Week', 'plan_id' => '91', 'price' => 600.00, 'validity' => 'Weekly'],
        ];

        foreach ($startimes_plans as $plan) {
            $startimes->plans()->create($plan);
        }
    }
}
