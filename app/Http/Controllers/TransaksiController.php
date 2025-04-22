<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    // crud keuangan masjid

    public function index()
    {
        return view('master.keuangan', [
            'title' => "Keuangan",
            'main_page' => '',
            'page' => 'Keuangan',
            'keuangan' => Transaksi::latest()->get(),
            'kategori' => Kategori::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_transaksi' => 'required',
            'kategori_id' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'jenis_transaksi.required' => 'Jenis Transaksi wajib diisi',
            'kategori_id.required' => 'Kategori wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addKeuangan', 'Gagal Menambah Keuangan');
        }

        Transaksi::create([
            'jenis_transaksi' => $request->input('jenis_transaksi'),
            'kategori_id' => $request->input('kategori_id'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            'user_id' => Auth::user()->id,
            'tanggal' => $request->input('tanggal'),
            'status_transaksi=>' => $request->input('status_transaksi'),
        ]);

        return redirect('/keuangan')->with('success', 'Berhasil menambah Keuangan');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_transaksi' => 'required',
            'kategori_id' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ], [
            'jenis_transaksi.required' => 'Jenis Transaksi wajib diisi',
            'kategori_id.required' => 'Kategori wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'keterangan.required' => 'Keterangan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateKeuangan', 'Gagal Update Keuangan');
        }

        Transaksi::where('id', $id)->update([
            'jenis_transaksi' => $request->input('jenis_transaksi'),
            'kategori_id' => $request->input('kategori_id'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            'user_id' => Auth::user()->id,
            'tanggal' => $request->input('tanggal'),
            'status_transaksi' => $request->input('status_transaksi'),
        ]);
        return redirect('/keuangan')->with('success', 'Berhasil Update Keuangan');
    }

    public function destroy(int $id)
    {
        $keuangan = Transaksi::find($id);
        if ($keuangan) {
            $keuangan->delete();
            return redirect('/keuangan')->with('success', 'Berhasil Menghapus Keuangan');
        } else {
            return redirect('/keuangan')->with('error', 'Keuangan tidak ditemukan');
        }
    }
}
