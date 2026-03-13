<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PlanCategory;
use Illuminate\Database\Seeder;

class PlanCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Data Share',
            'Gifting',
            'MTN Awoof'
        ];

        foreach ($categories as $category) {
            PlanCategory::updateOrCreate(
                ['name' => $category]
            );
        }
    }
}
