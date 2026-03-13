<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('network_id')
                  ->constrained('networks')
                  ->onDelete('cascade');

            $table->string('plan_id')->unique(); // provider data ID
            $table->string('plan_type');
            $table->string('plan_name'); // 10GB
            $table->decimal('price', 12, 2);
            $table->string('validity');
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_plans');
    }
};
