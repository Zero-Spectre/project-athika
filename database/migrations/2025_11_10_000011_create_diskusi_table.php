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
        // Create diskusi_topik table for discussion topics
        Schema::create('diskusi_topik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('judul', 255);
            $table->text('konten');
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->integer('jumlah_komentar')->default(0);
            $table->integer('jumlah_like')->default(0);
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
        });
        
        // Create diskusi_komentar table for discussion comments
        Schema::create('diskusi_komentar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('diskusi_topik_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('konten');
            $table->integer('jumlah_like')->default(0);
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('diskusi_topik_id')->references('id')->on('diskusi_topik')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('diskusi_komentar')->onDelete('cascade');
        });
        
        // Create diskusi_like table for tracking likes on topics and comments
        Schema::create('diskusi_like', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('diskusi_topik_id')->nullable();
            $table->unsignedBigInteger('diskusi_komentar_id')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('diskusi_topik_id')->references('id')->on('diskusi_topik')->onDelete('cascade');
            $table->foreign('diskusi_komentar_id')->references('id')->on('diskusi_komentar')->onDelete('cascade');
            
            // Ensure a user can only like a topic or comment once
            $table->unique(['user_id', 'diskusi_topik_id'], 'unique_user_topic_like');
            $table->unique(['user_id', 'diskusi_komentar_id'], 'unique_user_comment_like');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskusi_like');
        Schema::dropIfExists('diskusi_komentar');
        Schema::dropIfExists('diskusi_topik');
    }
};