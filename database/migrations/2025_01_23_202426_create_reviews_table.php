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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('review_cycle_id')->constrained()->on('review_cycles')->onDelete('cascade');
            $table->foreignId('reviewer_id')->nullable()->constrained()->on('users');
            $table->foreignId('reviewee_id')->nullable()->constrained()->on('users');
            $table->boolean('is_reviewed')->default(false);
            $table->double('average_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
