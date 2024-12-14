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
        Schema::create('product_basic_details', function (Blueprint $table) {
            $table->id();
            $table->string("product_id");
            $table->string("parent_code");
            $table->string("title");
            $table->string("description");
            $table->string("volume");
            $table->string("weight_net");
            $table->string("weight_gross");
            $table->string("dimension_length");
            $table->string("dimension_width");
            $table->string("dimension_height");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_basic_details');
    }
};
