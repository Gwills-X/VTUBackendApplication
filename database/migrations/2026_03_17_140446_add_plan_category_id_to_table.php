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
        Schema::table('available_data_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_category_id')->nullable()->after("updated_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_data_plans', function (Blueprint $table) {
            //
        });
    }
};
