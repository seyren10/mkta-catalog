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
        Schema::table('related_products', function (Blueprint $table) {

            $table->char('product_id', 250)->nullable();
            $table->char('related_product_id', 250)->nullable();

            $table->foreign('product_id') // Replace with your desired column name, e.g., 'product_id'
                ->nullable()
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('related_product_id') // Replace with your desired column name, e.g., 'product_id'
                ->nullable()
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('related_products', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Product::class, 'product_id');
            $table->dropForeignIdFor(\App\Models\Product::class, 'related_product_id');

        });

    }
};
