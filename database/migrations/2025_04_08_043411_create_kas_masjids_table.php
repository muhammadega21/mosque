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
        Schema::create('kas_masjid', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now());
            $table->enum('jenis_kas', ['kas masuk', 'kas keluar']);
            $table->integer('jumlah')->nullable();
            $table->string('keterangan');
            $table->enum('status_validasi', ['pending', 'selesai'])->default('pending');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('donasi_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori');
            $table->foreign('donasi_id')->references('id')->on('bukti_donasi')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_masjid');
    }
};
