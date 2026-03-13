<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableDataPlan;

class MissingDataPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [

            /*
            |--------------------------------------------------------------------------
            | MTN GIFTING (Missing Ones)
            |--------------------------------------------------------------------------
            */

            ['network'=>'mtn','network_code'=>1,'plan_id'=>604,'data'=>'2 GB','price'=>743,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>612,'data'=>'2 GB','price'=>1490,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>623,'data'=>'2.7 GB','price'=>1920,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>555,'data'=>'2.5 GB','price'=>891,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>660,'data'=>'3.2 GB','price'=>990,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>680,'data'=>'3.5 GB','price'=>1000,'validity'=>'1 day','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>679,'data'=>'4 GB','price'=>1200,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>678,'data'=>'5.5 GB','price'=>1500,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>609,'data'=>'6 GB','price'=>2475,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>645,'data'=>'11 GB','price'=>3465,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>607,'data'=>'16.5 GB','price'=>6435,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>681,'data'=>'34 GB','price'=>10000,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>541,'data'=>'20 GB','price'=>7425,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>542,'data'=>'25 GB','price'=>8910,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>544,'data'=>'75 GB','price'=>19800,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>545,'data'=>'150 GB','price'=>34650,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>546,'data'=>'250 GB','price'=>54450,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>650,'data'=>'800 GB','price'=>123750,'validity'=>'1 year','plan_category_id'=>2],

            /*
            |--------------------------------------------------------------------------
            | MTN AWOOF (Missing Ones)
            |--------------------------------------------------------------------------
            */

            ['network'=>'mtn','network_code'=>1,'plan_id'=>618,'data'=>'6 GB','price'=>2579,'validity'=>'7 days','plan_category_id'=>3],
            ['network'=>'mtn','network_code'=>1,'plan_id'=>624,'data'=>'14.5 GB','price'=>5099,'validity'=>'30 days','plan_category_id'=>3],

            /*
            |--------------------------------------------------------------------------
            | AIRTEL (All Missing Ones)
            |--------------------------------------------------------------------------
            */

            ['network'=>'airtel','network_code'=>2,'plan_id'=>577,'data'=>'6 GB','price'=>2475,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>579,'data'=>'300 MB','price'=>297,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>580,'data'=>'3 GB','price'=>1980,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>581,'data'=>'8 GB','price'=>2970,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>583,'data'=>'13 GB','price'=>4950,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>585,'data'=>'60 GB','price'=>14850,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>588,'data'=>'35 GB','price'=>9990,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>632,'data'=>'18 GB','price'=>4850,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>633,'data'=>'2 GB','price'=>1485,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>634,'data'=>'4 GB','price'=>2475,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>644,'data'=>'1 GB','price'=>792,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>648,'data'=>'1.5 GB','price'=>990,'validity'=>'7 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>651,'data'=>'100 GB','price'=>19800,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>661,'data'=>'75 MB','price'=>74.25,'validity'=>'1 day','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>662,'data'=>'100 MB','price'=>99,'validity'=>'Daily','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>663,'data'=>'3.2 GB','price'=>990,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>664,'data'=>'5 GB','price'=>1485,'validity'=>'2 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>665,'data'=>'10 GB','price'=>3960,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>666,'data'=>'25 GB','price'=>7920,'validity'=>'30 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>667,'data'=>'160 GB','price'=>29700,'validity'=>'Monthly','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>668,'data'=>'300 GB','price'=>49500,'validity'=>'90 days','plan_category_id'=>2],
            ['network'=>'airtel','network_code'=>2,'plan_id'=>669,'data'=>'350 GB','price'=>59400,'validity'=>'Monthly','plan_category_id'=>2],

        ];

        foreach ($plans as $plan) {
            AvailableDataPlan::updateOrCreate(
                ['plan_id' => $plan['plan_id']],
                $plan
            );
        }
    }
}
