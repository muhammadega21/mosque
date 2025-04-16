<?php

namespace Database\Seeders;

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
            'saldo' => 0,
            'user_id' => 1
        ]);

        User::create([
            'email' => 'dermawane988@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'jamaah'
        ]);
        UserData::create([
            'nama' => "Muhammad Ega Dermawan",
            "nomor_hp" => "08123456789",
            "alamat" => "Indonesia",
            'saldo' => 500000,
            'user_id' => 2
        ]);

        // User::factory(10)->create();
    }
}
