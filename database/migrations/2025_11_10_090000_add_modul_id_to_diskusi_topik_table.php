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
        Schema::table('diskusi_topik', function (Blueprint $table) {
            $table->unsignedBigInteger('modul_id')->nullable()->after('kategori_id');
            $table->foreign('modul_id')->references('id')->on('modul')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diskusi_topik', function (Blueprint $table) {
            $table->dropForeign(['modul_id']);
            $table->dropColumn('modul_id');
        });
    }
};