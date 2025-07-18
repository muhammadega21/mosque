<?php

namespace App\Http\Controllers;

use App\Models\BuktiDonasi;
use App\Models\KasMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BuktiDonasiController extends Controller
{
    public function index()
    {
        return view('donasi.index', [
            'title' => "Donasi",
            'main_page' => '',
            'page' => 'Donasi',
            'donasi' => BuktiDonasi::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_donatur' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_donatur.required' => 'Nama donatur wajib diisi',
            'gambar.required' => 'Bukti donasi wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addDonasi', 'Gagal Menambah Donasi');
        }

        $imagePath = $request->file('gambar')->store('bukti_donasi', 'public');

        $donasi = BuktiDonasi::create([
            'nama_donatur' => $request->input('nama_donatur'),
            'gambar' => $imagePath,
            'tanggal' => now(),
        ]);

        // Create kas masuk record if needed
        if ($request->has('jumlah') && $request->input('jumlah') > 0) {
            KasMasjid::create([
                'jenis_kas' => 'kas masuk',
                'kategori_id' => 1, // Adjust category ID as needed
                'jumlah' => $request->input('jumlah'),
                'keterangan' => 'Donasi dari ' . $request->input('nama_donatur'),
                'status_transaksi' => 'selesai',
                'donasi_id' => $donasi->id,
                'user_id' => Auth::user()->id,
            ]);
        }

        return redirect('/donasi')->with('success', 'Berhasil menambah Donasi');
    }

    public function cetak($id)
    {
        try {
            $donasi = BuktiDonasi::findOrFail($id);
            return view('donasi.cetak', compact('donasi'));
        } catch (\Exception $e) {
            return redirect('/donasi')->with('error', 'Gagal mencetak data');
        }
    }

    public function destroy($id)
    {
        $donasi = BuktiDonasi::find($id);
        if ($donasi) {
            Storage::disk('public')->delete($donasi->gambar);
            $donasi->delete();
            return redirect('/donasi')->with('success', 'Berhasil menghapus Donasi');
        }
        return redirect('/donasi')->with('error', 'Donasi tidak ditemukan');
    }
}
