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
        // 1. The Tags Table
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "LibGDX"
            $table->string('slug')->unique(); // e.g. "libgdx"
            $table->string('color')->default('bg-slate-700'); // CSS class for badge color
            $table->timestamps();
        });

        // 2. The Pivot Table (Connects Tags to Posts/Snippets)
        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('taggable_id');
            $table->string('taggable_type');

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
