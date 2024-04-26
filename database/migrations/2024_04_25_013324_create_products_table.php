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
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            $table->string('id')->primary()->comment('This is also be known as Item Code');
            $table->timestamps();

            $table->text('parent_code')->nullable();
            $table->text('title');
            $table->text('description')->nullable();
            
            $table->double('volume',8,2)->default(0.0);
            $table->double('weight_net',8,2)->default(0.0);
            $table->double('weight_gross',8,2)->default(0.0);

            $table->double('dimension_length',8,2)->default(0.0);
            $table->double('dimension_width',8,2)->default(0.0);
            $table->double('dimension_height',8,2)->default(0.0);

            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained('categories')->nullOnDelete()->cascadeOnUpdate();


    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Category::class);

        });
        Schema::dropIfExists('products');
    }
};
