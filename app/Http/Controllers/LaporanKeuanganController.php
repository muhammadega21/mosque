<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LaporanKeuanganController extends Controller
{
    // crud laporan keuangan
    public function index()
    {
        return view('master.laporan_keuangan', [
            'title' => "Laporan Keuangan",
            'main_page' => '',
            'page' => 'Laporan Keuangan',
            'laporanKeuangan' => LaporanKeuangan::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'laporan_periodik' => 'required|in:hari,minggu,bulan',
                'tanggal' => 'required|date',
            ],
            [
                'laporan_periodik.required' => 'Laporan periodik tidak boleh kosong',
                'laporan_periodik.in' => 'Laporan periodik tidak valid',
                'tanggal.required' => 'Tanggal tidak boleh kosong',
                'tanggal.date' => 'Tanggal tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addLaporanKeuangan', 'Gagal Membuat Laporan Keuangan, Silahkan Isi Form Dengan Benar');
        }

        $periode = $request->laporan_periodik;
        $tanggal = Carbon::parse($request->tanggal);

        if ($periode === 'hari') {
            $start = $tanggal->copy()->startOfDay();
            $end = $tanggal->copy()->endOfDay();
        } elseif ($periode === 'minggu') {
            $start = $tanggal->copy()->startOfWeek();
            $end = $tanggal->copy()->endOfWeek();
        } else {
            $start = $tanggal->copy()->startOfMonth();
            $end = $tanggal->copy()->endOfMonth();
        }

        $total = Transaksi::whereBetween('tanggal', [$start, $end])->sum('jumlah');

        if ($total === 0) {
            return redirect()->back()->with('error', 'Tidak ada transaksi untuk periode ini');
        }

        // Simpan ke DB jika belum ada
        $laporan = LaporanKeuangan::firstOrCreate([
            'tanggal' => $start,
            'laporan_periodik' => $periode,
        ], [
            'total_uang' => $total,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('LaporanKeuangan.cetak', $laporan->id);
    }

    public function cetak($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $tanggal = Carbon::parse($laporan->tanggal);

        if ($laporan->laporan_periodik === 'hari') {
            $transaksi = Transaksi::whereDate('tanggal', $tanggal)->get();
        } elseif ($laporan->laporan_periodik === 'minggu') {
            $startOfWeek = $tanggal->copy()->startOfWeek(Carbon::MONDAY);
            $endOfWeek = $tanggal->copy()->endOfWeek(Carbon::SUNDAY);
            $transaksi = Transaksi::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->get();
        } elseif ($laporan->laporan_periodik === 'bulan') {
            $transaksi = Transaksi::whereYear('tanggal', $tanggal->year)
                ->whereMonth('tanggal', $tanggal->month)
                ->get();
        } else {
            $transaksi = collect(); // fallback kosong jika tipe tidak dikenali
        }

        return view('master.cetak_laporan', [
            'laporan' => $laporan,
            'transaksi' => $transaksi
        ]);
    }

    public function destroy($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus laporan keuangan');
    }
}
