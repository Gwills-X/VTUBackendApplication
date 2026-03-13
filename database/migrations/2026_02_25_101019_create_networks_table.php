<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id(); // This will auto increment (1,2,3,4)
            $table->string('name')->unique(); // MTN
            $table->string('code')->unique(); // mtn
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('networks');
    }
};
