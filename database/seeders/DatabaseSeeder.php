<?php

namespace Database\Seeders;

use App\Models\InformasiMasjid;
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
            'nama_kategori' => 'Isi Saldo',
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

        InformasiMasjid::create([
            'tgl_post' => now(),
            'judul' => 'Tablig Akbar Bersama Ustadz Abdul Somad',
            'deskripsi' => 'Penceramah kondangan Ustadz Abdul Somad (UAS) dijadwalkan akan hadir dalam acara tabligh akbar di Masjid Al-Hamjirin, pada 5 hingga 6 Maret 2023 mendatang.',
            'kategori' => 'informasi',
            'gambar' => 'informasi_masjid/ceramah1.png',
            'user_id' => 1
        ]);

        InformasiMasjid::create([
            'tgl_post' => now(),
            'judul' => 'Pengumpulan Zakat',
            'deskripsi' => 'Mari kita berbagi kebahagiaan dengan berbagi sedekah. Pengumpulan zakat akan dilakukan pada tanggal 20 Maret 2023 di masjid Al-Hamjirin. Zakat yang terkumpul akan disalurkan kepada yang berhak menerimanya.',
            'kategori' => 'kegiatan',
            'gambar' => 'kegiatan_masjid/pengumpulanzakat.jpg',
            'user_id' => 1
        ]);

        InformasiMasjid::create([
            'tgl_post' => now(),
            'judul' => 'Pesantren Kilat Masjid Al-Hamjirin',
            'deskripsi' => 'Kami mengundang anak-anak untuk mengikuti pesantren kilat di masjid Al-Hamjirin pada tanggal 6 Maret hingga 25 Maret 2025. Pesantren ini bertujuan untuk meningkatkan pemahaman agama dan akhlak anak-anak.',
            'kategori' => 'kegiatan',
            'gambar' => 'kegiatan_masjid/pesantrenkilat.jpg',
            'user_id' => 1
        ]);

        InformasiMasjid::create([
            'tgl_post' => now(),
            'judul' => 'Ceramah Ustad  Adi Hidayat',
            'deskripsi' => 'Jadwal ceramah Ustad Adi Hidayat di masjid Al-Hamjirin dengan tema "Rahasia Shalat 5 Waktu" akan dilaksanakan pada tanggal 15 Maret 2023. Mari kita hadiri bersama-sama untuk mendapatkan ilmu yang bermanfaat.',
            'kategori' => 'informasi',
            'gambar' => 'informasi_masjid/ceramah2.jpg',
            'user_id' => 1
        ]);
    }
}
