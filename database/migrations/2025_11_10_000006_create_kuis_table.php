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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_id')->constrained('modul');
            $table->text('question');
            $table->string('option_a', 255)->nullable();
            $table->string('option_b', 255)->nullable();
            $table->string('option_c', 255)->nullable();
            $table->string('option_d', 255)->nullable();
            $table->char('correct_answer', 1);
            $table->integer('score_weight')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};