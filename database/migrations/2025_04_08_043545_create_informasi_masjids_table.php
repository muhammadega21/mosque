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
        Schema::create('informasi_masjid', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_post');
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('kategori', ['informasi', 'kegiatan']);
            $table->string('gambar');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_masjid');
    }
};
