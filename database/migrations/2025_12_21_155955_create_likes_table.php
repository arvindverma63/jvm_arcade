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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            // 1. Manually define the column as CHAR(36) to match your User Model
            $table->char('user_id', 36);

            // 2. Manually define the constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Polymorphic columns (likeable_id + likeable_type)
            $table->morphs('likeable');

            $table->timestamps();

            // Prevent duplicate likes
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
