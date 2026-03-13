<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        */
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        Wallet::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'balance' => 5000,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Normal Test User
        |--------------------------------------------------------------------------
        */
        $user = User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        Wallet::updateOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 2000,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Core System Seeders
        |--------------------------------------------------------------------------
        */
        $this->call([
            NetworkSeeder::class,
            DataPlanSeeder::class,
        ]);
    }
}
