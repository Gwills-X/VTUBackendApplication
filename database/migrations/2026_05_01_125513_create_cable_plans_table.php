<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('cable_plans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cable_provider_id')->constrained()->onDelete('cascade');
    $table->string('plan_name');
    $table->string('plan_id'); // The ID used for the API call
    $table->decimal('price', 10, 2);
    $table->string('validity');
    $table->boolean('is_active')->default(true);
    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cable_plans');
    }
};
