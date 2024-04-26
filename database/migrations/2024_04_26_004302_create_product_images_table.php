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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('is_thumbnail')->comment('0 -> false, 1 -> true')->default(false);
            $table->foreignIdFor(\App\Models\File::class)->nullable()->constrained('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\File::class);
            $table->dropForeignIdFor(\App\Models\Product::class);

        });
        Schema::dropIfExists('product_images');
    }
};
