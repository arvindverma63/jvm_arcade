<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Follows Table
        Schema::create('follows', function (Blueprint $table) {
            $table->id();

            // FIX: Use CHAR(36) for UUIDs instead of foreignId()
            $table->char('follower_id', 36);
            $table->char('following_id', 36);

            // Manual Foreign Key Constraints
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            // Prevent duplicate follows
            $table->unique(['follower_id', 'following_id']);
        });

        // 2. Blocks Table
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            // FIX: Use CHAR(36) for UUIDs
            $table->char('blocker_id', 36);
            $table->char('blocked_id', 36);

            // Manual Foreign Key Constraints
            $table->foreign('blocker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blocked_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            // Prevent duplicate blocks
            $table->unique(['blocker_id', 'blocked_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('follows');
    }
};
