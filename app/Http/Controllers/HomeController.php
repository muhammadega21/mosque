<?php

namespace App\Http\Controllers;

use App\Models\BuktiDonasi;
use App\Models\InformasiMasjid;
use App\Models\KasMasjid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $kas_masjid = KasMasjid::where('status_validasi', 'selesai')->orderBy('tanggal', 'desc')
            ->take(10);

        return view('landing_page.index', [
            'title' => "DokuMosque | Masjid Al-Hamujirin",
            'total_donasi' => $total_donasi,
            'donatur' => $total_user,
            'kegiatan_masjid' => $kegiatan_masjid->get(),
            'informasi_masjid' => $informasi_masjid->get(),
            'kas_masjid' => $kas_masjid->get(),
        ]);
    }

    public function donasi(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'nama_donatur' => 'max:50',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'nama_donatur.max' => 'Nama donatur maksimal 50 karakter',
                'gambar.required' => 'Bukti pembayaran wajib diisi',
                'gambar.image' => 'File harus berupa gambar',
                'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'gambar.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            if ($validator->fails()) {
                $errors = implode(', ', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput()->with('error', $errors);
            }

            $namaDonatur = $request->has('anonymousCheckbox') ? 'Hamba Allah' : $request->nama_donatur;

            $imagePath = null;
            if ($request->file('gambar')) {
                $imagePath = $request->file('gambar')->store('donasi');
            }

            $donasi = BuktiDonasi::create([
                'nama_donatur' => $namaDonatur,
                'gambar' => $imagePath,
                'tanggal' => now(),
            ]);

            KasMasjid::create([
                'tanggal' => now(),
                'jenis_kas' => 'kas masuk',
                'keterangan' => 'Donasi dari ' . $namaDonatur,
                'status_transaksi' => 'pending',
                'kategori_id' => 1,
                'donasi_id' => $donasi->id,
                'user_id' => null
            ]);

            return redirect()->back()->with('success', 'Donasi berhasil dikirim!');
        }

        return view('landing_page.donasi', [
            'title' => "Donasi",
        ]);
    }
}
