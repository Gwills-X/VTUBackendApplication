<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('available_data_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('network_plan_category_id')->nullable()->after('plan_category_id');

            $table->foreign('network_plan_category_id')
                ->references('id')
                ->on('network_plan_categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('available_data_plans', function (Blueprint $table) {
            $table->dropForeign(['network_plan_category_id']);
            $table->dropColumn('network_plan_category_id');
        });
    }
};
