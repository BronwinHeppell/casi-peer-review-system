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
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('review_cycle_id')->constrained()->on('review_cycles');
            $table->foreignId('user_id')->constrained()->on('users');
            $table->string('manager_comment')->nullable();
            $table->string('comment')->nullable();
            $table->decimal('average_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
};
