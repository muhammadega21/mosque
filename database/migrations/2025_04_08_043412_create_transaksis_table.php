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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis_transaksi');
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->enum('status_transaksi', ['selesai', 'pending', 'batal'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('laporan_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('laporan_id')->references('id')->on('laporan_keuangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
