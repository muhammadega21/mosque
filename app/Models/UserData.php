<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = 'user_data';

    protected $fillable = [
        'nama',
        'nomor_hp',
        'alamat',
        'status',
        'saldo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
