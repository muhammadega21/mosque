<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'tanggal',
        'jenis_transaksi',
        'jumlah',
        'keterangan',
        'status_transaksi',
        'user_id',
        'kategori_id',
        'gambar'
    ];
    protected $with = ['user', 'laporan', 'kategori'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function laporan()
    {
        return $this->belongsTo(LaporanKeuangan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
