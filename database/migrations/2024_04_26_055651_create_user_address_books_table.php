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
        Schema::create('user_address_books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('company')->nullable();
            $table->string('full_address')->nullable();
            $table->string('contact_number')->nullable();

            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_address_books', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
        });
        Schema::dropIfExists('user_address_books');
    }
};
