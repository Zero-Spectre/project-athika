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
        Schema::create('kursus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instruktur_id')->constrained('users');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->enum('status_publish', ['Draft', 'Published', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursus');
    }
};