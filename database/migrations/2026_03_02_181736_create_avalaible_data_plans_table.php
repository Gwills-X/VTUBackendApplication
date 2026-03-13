<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_data_plans', function (Blueprint $table) {
            $table->id(); // primary key

            $table->string('network'); // mtn, airtel
            $table->integer('network_code'); // 1, 2, 3...
            $table->integer('plan_id'); // provider plan id
            $table->string('plan_type'); // GIFTING, DATA SHARE, AWOOF
            $table->string('data'); // 1GB, 2GB
            $table->decimal('price', 15, 2);
            $table->string('validity'); // 7 days, 30 days
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_plans');
    }
};
