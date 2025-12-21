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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 36);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body'); // Supports Markdown
            $table->string('type')->default('discussion'); // discussion, news, help_wanted, showcase
            $table->integer('views')->default(0);
            $table->integer('votes')->default(0);
            $table->boolean('is_solved')->default(false); // For Q&A
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
