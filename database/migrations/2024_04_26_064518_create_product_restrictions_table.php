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
        Schema::create('product_restrictions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\ProductAccessType::class)->nullable()->constrained('product_access_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('value')->nullable()->comment('Restriction value');
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_restrictions', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\ProductAccessType::class);
            $table->dropForeignIdFor(\App\Models\Product::class);
        });
        Schema::dropIfExists('product_restrictions');
    }
};
