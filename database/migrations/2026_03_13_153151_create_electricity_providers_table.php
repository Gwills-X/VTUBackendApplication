<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electricity_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // E.g., Ikeja Electric
            $table->string('code')->unique(); // optional, like provider code
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electricity_providers');
    }
};
