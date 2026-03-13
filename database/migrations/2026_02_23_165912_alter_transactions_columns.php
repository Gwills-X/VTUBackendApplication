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
        Schema::table('transactions', function (Blueprint $table) {
            // Change 'type' column to ENUM with proper service types
            $table->enum('type', ['buy_airtime', 'buy_data', 'wallet_fund'])
                  ->default('buy_airtime')
                  ->change();

            // Change 'status' column to ENUM with proper statuses
            $table->enum('status', ['pending', 'success', 'failed'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Optionally revert back to string (or your old type)
            $table->string('type')->change();
            $table->string('status')->default('completed')->change();
        });
    }
};
