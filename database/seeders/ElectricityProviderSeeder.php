<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElectricityProvider;

class ElectricityProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [

            ['id'=>1,'name'=>'JOS ELECTRIC','code'=>'jos','status'=>true],
            ['id'=>2,'name'=>'KANO ELECTRIC','code'=>'kano','status'=>true],
            ['id'=>3,'name'=>'IKEJA ELECTRIC','code'=>'ikeja','status'=>true],
            ['id'=>4,'name'=>'EKO ELECTRIC','code'=>'eko','status'=>true],
            ['id'=>5,'name'=>'ABUJA ELECTRIC','code'=>'abuja','status'=>true],
            ['id'=>6,'name'=>'ENUGU ELECTRIC','code'=>'enugu','status'=>true],
            ['id'=>7,'name'=>'PORT HARCOURT ELECTRIC','code'=>'ph','status'=>true],
            ['id'=>8,'name'=>'IBADAN ELECTRIC','code'=>'ibadan','status'=>true],
            ['id'=>9,'name'=>'KADUNA ELECTRIC','code'=>'kaduna','status'=>true],
            ['id'=>10,'name'=>'BENIN ELECTRIC','code'=>'benin','status'=>true],
            ['id'=>11,'name'=>'YOLA ELECTRIC','code'=>'yola','status'=>true],

        ];

        foreach ($providers as $provider) {
            ElectricityProvider::updateOrCreate(
                ['id' => $provider['id']],
                $provider
            );
        }
    }
}
