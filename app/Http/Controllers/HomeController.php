<?php

namespace App\Http\Controllers;

use App\Models\InformasiMasjid;
use App\Models\KasMasjid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $uang_masjid = KasMasjid::where('jenis_kas', 'kas masuk')->sum('jumlah') -
            KasMasjid::where('jenis_kas', 'kas keluar')->sum('jumlah');
        $riwayat_donasi = KasMasjid::orderBy('created_at', 'desc')
            ->take(6)
            ->get();


        $tahun = date('Y');

        // Ambil total uang masuk per bulan
        $uang_masuk = KasMasjid::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('jenis_kas', 'kas masuk')
            ->whereYear('tanggal', $tahun)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan')
            ->toArray();

        // Ambil total uang keluar per bulan
        $uang_keluar = KasMasjid::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('jenis_kas', 'kas keluar')
            ->whereYear('tanggal', $tahun)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan')
            ->toArray();

        // Buat array 12 bulan agar hasil selalu lengkap meskipun tidak ada data di suatu bulan
        $uang_masuk_lengkap = [];
        $uang_keluar_lengkap = [];

        for ($i = 1; $i <= 12; $i++) {
            $uang_masuk_lengkap[] = isset($uang_masuk[$i]) ? (int)$uang_masuk[$i] : 0;
            $uang_keluar_lengkap[] = isset($uang_keluar[$i]) ? (int)$uang_keluar[$i] : 0;
        }

        return view('dashboard', [
            'title' => "Dashboard",
            'main_page' => '',
            'page' => 'Dashboard',
            'total_user' => User::all()->count(),
            'uang_masjid' => $uang_masjid,
            'uang_masuk' => json_encode($uang_masuk_lengkap),
            'uang_keluar' => json_encode($uang_keluar_lengkap),
            'riwayat_donasi' => $riwayat_donasi,
        ]);
    }

    public function landingPage()
    {
        $total_donasi = KasMasjid::where('jenis_kas', 'kas masuk')->sum('jumlah');
        $total_user = User::all()->count();
        $kegiatan_masjid = InformasiMasjid::latest()->where('kategori', 'kegiatan')->take(6);
        $informasi_masjid = InformasiMasjid::latest()->where('kategori', 'informasi')->take(6);
        $kas_masjid = KasMasjid::orderBy('created_at', 'desc')
            ->paginate(15);

        return view('landing_page.index', [
            'title' => "DokuMosque | Masjid Al-Hamujirin",
            'total_donasi' => $total_donasi,
            'donatur' => $total_user,
            'kegiatan_masjid' => $kegiatan_masjid->get(),
            'informasi_masjid' => $informasi_masjid->get(),
            'kas_masjid' => $kas_masjid,
        ]);
    }
}
