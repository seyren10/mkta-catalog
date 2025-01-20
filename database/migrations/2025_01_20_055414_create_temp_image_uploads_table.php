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
        Schema::create('temp_image_uploads', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_thumbnail')->comment('0 -> false, 1 -> true')->default(false);
            $table->foreignIdFor(\App\Models\File::class)->nullable()->constrained('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('index')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_image_uploads');
    }
};
