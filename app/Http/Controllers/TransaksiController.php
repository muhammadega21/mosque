<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'keuangan' => Transaksi::orderByRaw('FIELD(status_transaksi, "pending") DESC')
                ->orderBy('created_at', 'desc')
                ->orderByRaw('FIELD(status_transaksi, "pending", "batal", "selesai")')
                ->paginate(15),
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
            if ($keuangan->gambar) {
                Storage::delete($keuangan->gambar);
            }
            $keuangan->delete();
            return redirect('/keuangan')->with('success', 'Berhasil Menghapus Keuangan');
        } else {
            return redirect('/keuangan')->with('error', 'Keuangan tidak ditemukan');
        }
    }

    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required|exists:transaksi,id',
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric'
        ], [
            'transaksi_id.required' => 'Transaksi wajib diisi',
            'transaksi_id.exists' => 'Transaksi tidak ditemukan',
            'user_id.required' => 'User wajib diisi',
            'user_id.exists' => 'User tidak ditemukan',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Gagal menyetujui pembayaran');
        }


        Transaksi::where('id', $request->transaksi_id)->update([
            'status_transaksi' => 'selesai',
        ]);

        UserData::where('id', $request->user_id)->update([
            'saldo' => DB::raw('saldo + ' . $request->jumlah)
        ]);

        return redirect('/keuangan')->with('success', 'Pembayaran berhasil disetujui');
    }

    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required|exists:transaksi,id',
        ], [
            'transaksi_id.required' => 'ID Transaksi wajib diisi',
            'transaksi_id.exists' => 'Transaksi tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Gagal menolak pembayaran');
        }

        Transaksi::where('id', $request->transaksi_id)->update([
            'status_transaksi' => 'batal',
        ]);

        return redirect('/keuangan')->with('success', 'Pembayaran berhasil ditolak');
    }
}
