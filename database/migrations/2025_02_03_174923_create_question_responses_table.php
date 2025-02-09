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
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('review_id')->constrained()->on('reviews');
            $table->foreignId('question_id')->constrained()->on('questions');
            $table->foreignId('reviewer_id')->constrained()->on('users');
            $table->string('comment')->nullable();
            $table->integer('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_responses');
    }
};
