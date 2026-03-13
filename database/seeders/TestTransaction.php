<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Transaction;

class TestTransaction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::where("email", "user@test.com")->first();

        if(!$user){
            $this->command->error('Test User Not Found');
        }

        Transaction::create([
            "user_id"=>$user->id,
            "type" => "wallet_fund",
            "amount"=>1000,
            "status"=>"completed"
        ]);

        Transaction::create([
            "user_id"=> $user->id,
            "type"=>"wallet_fund",
            "amount"=>2000,
            "status"=>"completed"
        ]);


    }
}
