<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';
    protected $with = ['user', 'transaksi'];

    protected $fillable = [
        'tanggal',
        'laporan_periodik',
        'total_uang',
        'user_id',
        'transaksi_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
