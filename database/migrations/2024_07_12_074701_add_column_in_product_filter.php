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
        Schema::table('product_filters', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\FilterChoice::class)->nullable()->constrained('filter_choices')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_filters', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\FilterChoice::class);
        });
    }
};
