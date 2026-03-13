<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Network;

class NetworkSeeder extends Seeder
{
    public function run()
    {
        $networks = [
            ['id' => 1, 'name' => 'MTN', 'code' => 'mtn'],
            ['id' => 2, 'name' => 'GLO', 'code' => 'glo'],
            ['id' => 3, 'name' => '9MOBILE', 'code' => '9mobile'],
            ['id' => 4, 'name' => 'AIRTEL', 'code' => 'airtel'],
        ];

        foreach ($networks as $network) {
            Network::updateOrCreate(
                ['id' => $network['id']],
                $network
            );
        }
    }
}
