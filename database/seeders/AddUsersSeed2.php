<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class AddUsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User 3',
            'email' => 'admin3@test.com',
            'password' => 'password', // auto-hashed because of cast
            'is_admin' => true,
        ]);

        Wallet::create([
            'user_id' => $admin->id,
            'balance' => 4000,
        ]);

        $user= User::create([
            "name" =>"Normal User 2",
            "email"=> "normaluser2@gmail.com",
            "password"=>"password",
            "is_admin"=> false,

        ]);

        Wallet::create([
            "user_id"=>$user->id,
            "balance" => 500
        ]);
    }
}
