<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiMasjid extends Model
{
    protected $table = 'informasi_masjid';
    protected $with = ['user'];

    protected $fillable = [
        'tgl_post',
        'judul',
        'deskripsi',
        'gambar',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
