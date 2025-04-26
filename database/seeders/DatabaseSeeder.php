<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\UserData;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'pengurus'
        ]);
        UserData::create([
            'nama' => "Admin",
            "nomor_hp" => "08123456789",
            "alamat" => "Indonesia",
            'saldo' => 20000,
            'user_id' => 1
        ]);

        Kategori::create([
            'nama_kategori' => 'Donasi',
        ]);
        Kategori::create([
            'nama_kategori' => 'Zakat',
        ]);
        Kategori::create([
            'nama_kategori' => 'Iuran Masjid',
        ]);
        Kategori::create([
            'nama_kategori' => 'Infaq Jumat',
        ]);

        User::factory(20)->create();
        Transaksi::factory(50)->create();
    }
}
