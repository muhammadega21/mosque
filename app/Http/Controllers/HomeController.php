<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $donasi_user = Transaksi::where('user_id', Auth::user()->id)->whereMonth('created_at', date('m'))->sum('jumlah');
        $uang_masjid = Transaksi::where('jenis_transaksi', 'masuk')->sum('jumlah') - Transaksi::where('jenis_transaksi', 'keluar')->sum('jumlah');
        if (Auth::user()->role == 'pengurus') {
            $riwayat_donasi = Transaksi::where('jenis_transaksi', 'masuk')->orderBy('created_at', 'desc')->take(6)->get();
        } else {
            $riwayat_donasi = Transaksi::where('user_id', Auth::user()->id)->where('jenis_transaksi', 'masuk')->orderBy('created_at', 'desc')->take(6)->get();
        }

        $tahun = date('Y');

        // Ambil total uang masuk per bulan
        $uang_masuk = Transaksi::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('jenis_transaksi', 'masuk')
            ->whereYear('tanggal', $tahun)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan')
            ->toArray();

        // Ambil total uang keluar per bulan
        $uang_keluar = Transaksi::selectRaw('MONTH(tanggal) as bulan, SUM(jumlah) as total')
            ->where('jenis_transaksi', 'keluar')
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
            'saldo' => Auth::user()->user_data->saldo,
            'donasi_user' => $donasi_user,
            'total_user' => User::all()->count(),
            'uang_masjid' => $uang_masjid,
            'uang_masuk' => json_encode($uang_masuk_lengkap),
            'uang_keluar' => json_encode($uang_keluar_lengkap),
            'riwayat_donasi' => $riwayat_donasi,
        ]);
    }
}
