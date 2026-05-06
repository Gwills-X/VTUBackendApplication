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
       Schema::create('cable_providers', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // GOtv, DStv, StarTimes
    $table->string('api_id'); // Network ID from Topify
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
        Schema::dropIfExists('cable_providers');
    }
};
