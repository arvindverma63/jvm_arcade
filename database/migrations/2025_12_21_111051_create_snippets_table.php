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
        Schema::create('snippets', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 36); // Matches User UUID
            $table->string('title');
            $table->string('slug')->unique(); // for URLs like /snippet/my-cool-code
            $table->text('code'); // The actual code
            $table->text('description')->nullable();
            $table->string('language')->default('Java'); // Java, Kotlin, etc.
            $table->integer('likes_count')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snippets');
    }
};
