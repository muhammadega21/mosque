<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasjid extends Model
{
    use HasFactory;
    protected $table = 'kas_masjid';
    protected $fillable = [
        'tanggal',
        'jenis_kas',
        'jumlah',
        'keterangan',
        'status_validasi',
        'user_id',
        'kategori_id',
        'donasi_id'
    ];
    protected $with = ['user', 'laporan', 'kategori', 'donasi'];
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

    public function donasi()
    {
        return $this->belongsTo(BuktiDonasi::class, 'donasi_id');
    }
}
