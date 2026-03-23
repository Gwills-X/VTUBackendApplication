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
        // Use json() so you can easily cast it in your Model
        $table->json('meta')->nullable()->after('phone_number');
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn('meta');
    });
}
};
