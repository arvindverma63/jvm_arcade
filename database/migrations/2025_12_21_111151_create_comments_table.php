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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 36);
            $table->text('body');

            // Polymorphic Fields: This allows comments on Posts OR Snippets
            // commentable_id (integer) and commentable_type (string model path)
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');

            $table->boolean('is_solution')->default(false); // If this comment solves the post
            $table->integer('votes')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
