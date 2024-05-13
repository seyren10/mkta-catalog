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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained('categories')->nullOnDelete()->cascadeOnUpdate();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Product::class);
            $table->dropForeignIdFor(\App\Models\Category::class);
        });
        Schema::dropIfExists('product_categories');
    }
};
