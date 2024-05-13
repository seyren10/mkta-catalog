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
        Schema::create('user_areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\AreaCode::class)->nullable()->constrained('area_codes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_areas', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\AreaCode::class);
            $table->dropForeignIdFor(\App\Models\User::class);
        });
        Schema::dropIfExists('user_areas');
    }
};
