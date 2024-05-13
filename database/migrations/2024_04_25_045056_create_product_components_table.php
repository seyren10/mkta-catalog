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
        Schema::create('product_components', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->enum('type', ['html', 'list', 'file', 'text', 'image', 'table', 'album', 'video']);
            $table->boolean('is_visible')->comment('0 -> false, 1 -> true')->default(false);

            $table->integer('index')->default(0);
            $table->text('title');
            $table->text('value')->comment('depends on the type');
            
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_components', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Product::class);

        });
        Schema::dropIfExists('product_components');
    }
};
