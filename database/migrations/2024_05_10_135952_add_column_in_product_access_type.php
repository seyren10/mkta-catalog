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
        Schema::table('product_access_types', function (Blueprint $table) {
            $table->enum('ref_type', ['direct', 'indirect']);
            $table->text('ref_table');
            $table->text('ref_column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_access_types', function (Blueprint $table) {
            $table->removeColumn('ref_type');
            $table->removeColumn('ref_table');
            $table->removeColumn('ref_column');
        });
    }
};
