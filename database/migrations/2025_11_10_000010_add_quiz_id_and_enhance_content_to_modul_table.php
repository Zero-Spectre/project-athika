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
        Schema::table('modul', function (Blueprint $table) {
            // Add nullable quiz_id foreign key
            $table->foreignId('quiz_id')->nullable()->constrained('kuis')->after('kursus_id');
            
            // Add additional fields for enhanced content
            $table->text('penjelasan')->nullable()->after('konten_teks');
            $table->string('video_thumbnail', 255)->nullable()->after('url_video');
            $table->text('video_deskripsi')->nullable()->after('video_thumbnail');
            $table->integer('durasi_video')->nullable()->after('video_deskripsi'); // in seconds
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modul', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn(['quiz_id', 'penjelasan', 'video_thumbnail', 'video_deskripsi', 'durasi_video']);
        });
    }
};