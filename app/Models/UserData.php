<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $table = 'user_data';

    protected $fillable = [
        'nama',
        'nomor_hp',
        'alamat',
        'status',
        'saldo',
        'user_id',
    ];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
