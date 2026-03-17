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
            // Add 'buy_electricity' to type ENUM
            $table->enum('type', ['buy_airtime', 'buy_data', 'wallet_fund', 'buy_electricity'])
                  ->default('buy_airtime')
                  ->change();

            // Keep status ENUM as it is
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
            // Revert type ENUM back to original without buy_electricity
            $table->enum('type', ['buy_airtime', 'buy_data', 'wallet_fund'])
                  ->default('buy_airtime')
                  ->change();

            $table->enum('status', ['pending', 'success', 'failed'])
                  ->default('pending')
                  ->change();
        });
    }
};
