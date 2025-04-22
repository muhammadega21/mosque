<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';
    protected $with = ['user'];

    protected $fillable = [
        'tanggal',
        'laporan_periodik',
        'total_uang',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
