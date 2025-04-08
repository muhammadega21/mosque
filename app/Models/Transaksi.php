<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'jumlah',
        'keterangan',
        'status_transaksi',
        'user_id',
        'laporan_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanKeuangan::class, 'laporan_id');
    }
}
