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
        Schema::table('categories', function (Blueprint $table) {
            $table->longText('cover_html')->default('<div
                class="aspect-video overflow-hidden rounded-lg bg-slate-200 md:col-start-2 md:row-start-1 md:row-end-3"
            >
                <img
                    no-overlay
                    src="{{category_image}}"
                    class="h-full w-full object-cover"
                />
            </div>
            <div>
                <h1
                    class="my-5 text-head font-light uppercase tracking-wide text-primary"
                >
                    {{category_title}}
                </h1>
                <p class="max-w-[50ch] text-slate-500">
                    {{category_description}}
                </p>
            </div>');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->removeColumn('cover_html');
        });
    }
};
