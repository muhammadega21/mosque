<?php

namespace App\Http\Controllers;

use App\Models\KasMasjid;
use App\Models\Kategori;
use App\Models\BuktiDonasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KasMasjidController extends Controller
{
    public function index()
    {
        return view('master.kas_masjid', [
            'title' => "Kas Masjid",
            'main_page' => '',
            'page' => 'Kas Masjid',
            'kas_masjid' => KasMasjid::orderBy('created_at', 'desc')
                ->paginate(15),
            'kategori' => Kategori::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kas' => 'required',
            'kategori_id' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'jenis_kas.required' => 'Jenis Kas wajib diisi',
            'kategori_id.required' => 'Kategori wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addKasMasjid', 'Gagal Menambah Kas Masjid');
        }

        KasMasjid::create([
            'jenis_kas' => $request->input('jenis_kas'),
            'kategori_id' => $request->input('kategori_id'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            'user_id' => Auth::user()->id,
            'tanggal' => $request->input('tanggal'),
            'status_transaksi' => $request->input('status_transaksi'),
            'donasi_id' => $request->input('donasi_id') ?? null,
        ]);

        return redirect('/kas-masjid')->with('success', 'Berhasil menambah Kas Masjid');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kas' => 'required',
            'kategori_id' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'jenis_kas.required' => 'Jenis Kas wajib diisi',
            'kategori_id.required' => 'Kategori wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateKasMasjid', 'Gagal Update Kas Masjid');
        }

        KasMasjid::where('id', $id)->update([
            'jenis_kas' => $request->input('jenis_kas'),
            'kategori_id' => $request->input('kategori_id'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            'user_id' => Auth::user()->id,
            'tanggal' => $request->input('tanggal'),
            'status_transaksi' => $request->input('status_transaksi'),
            'donasi_id' => $request->input('donasi_id') ?? null,
        ]);

        return redirect('/kas-masjid')->with('success', 'Berhasil Update Kas Masjid');
    }

    public function destroy(int $id)
    {
        $kas = KasMasjid::find($id);
        if ($kas) {
            $kas->delete();
            return redirect('/kas-masjid')->with('success', 'Berhasil Menghapus Kas Masjid');
        }
        return redirect('/kas-masjid')->with('error', 'Kas Masjid tidak ditemukan');
    }
}
