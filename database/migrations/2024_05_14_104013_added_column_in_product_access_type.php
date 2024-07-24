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
            $table->text('source_table');
            $table->text('source_column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_access_types', function (Blueprint $table) {
            $table->dropColumn('source_table');
            $table->dropColumn('source_column');
        });
    }
};
