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
        Schema::create('modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kursus_id')->constrained('kursus');
            $table->string('judul', 255);
            $table->enum('tipe_materi', ['Video', 'Artikel', 'Kuis']);
            $table->integer('urutan');
            $table->text('konten_teks')->nullable();
            $table->string('url_video', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};