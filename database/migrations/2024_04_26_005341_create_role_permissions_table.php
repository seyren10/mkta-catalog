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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\Role::class)->nullable()->constrained('roles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Permission::class)->nullable()->constrained('permissions')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Role::class);
            $table->dropForeignIdFor(\App\Models\Permission::class);

        });
        Schema::dropIfExists('role_permissions');
    }
};
