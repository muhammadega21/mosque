<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\KasMasjid;
use App\Models\Kategori;
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
            'kategori' => Kategori::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'laporan_periodik' => 'required|in:hari,minggu,bulan,tahun',
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
        $kategori = $request->kategori ?? 'semua';

        if ($periode === 'hari') {
            $start = $tanggal->copy()->startOfDay();
            $end = $tanggal->copy()->endOfDay();
        } elseif ($periode === 'minggu') {
            $start = $tanggal->copy()->startOfWeek();
            $end = $tanggal->copy()->endOfWeek();
        } elseif ($periode === 'bulan') {
            $start = $tanggal->copy()->startOfMonth();
            $end = $tanggal->copy()->endOfMonth();
        } elseif ($periode === 'tahun') {
            $start = $tanggal->copy()->startOfYear();
            $end = $tanggal->copy()->endOfYear();
        } else {
            return redirect()->back()->with('error', 'Periode tidak valid');
        }

        // Jika kategori tidak 'semua', filter berdasarkan kategori
        if ($kategori !== 'semua') {
            $total = KasMasjid::where('kategori_id', $kategori)
                ->whereBetween('tanggal', [$start, $end])
                ->sum('jumlah');
        } else {

            $total = KasMasjid::whereBetween('tanggal', [$start, $end])
                ->sum('jumlah');
        }

        if ($total === 0) {
            return redirect()->back()->with('error', 'Tidak ada transaksi untuk periode ini');
        }

        $laporan = LaporanKeuangan::updateOrCreate(
            [
                'tanggal' => $tanggal->format('Y-m-d'),
                'laporan_periodik' => $periode,
            ],
            [
                'total_uang' => $total,
                'user_id' => Auth::user()->id,
                'periode_start' => $start->format('Y-m-d'),
                'periode_end' => $end->format('Y-m-d'),
                'kategori_id' => $kategori !== 'semua' ? $kategori : null,
            ]
        );

        return redirect()->route('LaporanKeuangan.cetak', $laporan->id);
    }

    public function cetak($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);

        // Gunakan periode_start dan periode_end yang sudah disimpan
        if ($laporan->periode_start && $laporan->periode_end) {
            $transaksi = KasMasjid::whereBetween('tanggal', [
                $laporan->periode_start,
                $laporan->periode_end
            ])->get();
        } else {
            // Fallback untuk data lama
            $tanggal = Carbon::parse($laporan->tanggal);

            if ($laporan->laporan_periodik === 'hari') {
                if ($laporan->kategori_id === null) {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')->whereDate('tanggal', $tanggal)->get();
                } else {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')
                        ->whereDate('tanggal', $tanggal)
                        ->where('kategori_id', $laporan->kategori_id)
                        ->get();
                }
            } elseif ($laporan->laporan_periodik === 'minggu') {
                $startOfWeek = $tanggal->copy()->startOfWeek(Carbon::MONDAY);
                $endOfWeek = $tanggal->copy()->endOfWeek(Carbon::SUNDAY);
                if ($laporan->kategori_id === null) {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')->whereBetween('tanggal', [$startOfWeek, $endOfWeek])->get();
                } else {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')
                        ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                        ->where('kategori_id', $laporan->kategori_id)
                        ->get();
                }
            } elseif ($laporan->laporan_periodik === 'bulan') {
                if ($laporan->kategori_id === null) {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')->whereYear('tanggal', $tanggal->year)
                        ->whereMonth('tanggal', $tanggal->month)
                        ->get();
                } else {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')
                        ->whereYear('tanggal', $tanggal->year)
                        ->whereMonth('tanggal', $tanggal->month)
                        ->where('kategori_id', $laporan->kategori_id)
                        ->get();
                }
            } elseif ($laporan->laporan_periodik === 'tahun') {
                if ($laporan->kategori_id === null) {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')->whereYear('tanggal', $tanggal->year)->get();
                } else {
                    $transaksi = KasMasjid::where('status_validasi', 'selesai')
                        ->whereYear('tanggal', $tanggal->year)
                        ->where('kategori_id', $laporan->kategori_id)
                        ->get();
                }
            } else {
                return redirect()->back()->with('error', 'Periode tidak valid');
            }
        }

        return view('master.cetak_laporan', [
            'laporan' => $laporan,
            'transaksi' => $transaksi,
            'kategori' => Kategori::all(),
        ]);
    }

    public function destroy($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus laporan keuangan');
    }
}
