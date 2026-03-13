<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('network_plan_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // MTN Data Share
            $table->unsignedBigInteger('plan_category_id');
            $table->timestamps();

            $table->foreign('plan_category_id')
                ->references('id')
                ->on('plan_categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('network_plan_categories');
    }
};
