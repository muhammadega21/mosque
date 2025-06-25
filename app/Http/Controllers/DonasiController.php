<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonasiController extends Controller
{
    // crud donasi
    public function index()
    {
        return view('donasi.index', [
            'title' => "Donasi",
            'main_page' => '',
            'page' => 'Donasi',
            'donasi' => Transaksi::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required|numeric',
        ], [
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addDonasi', 'Gagal Melakukan Donasi, Silahkan Isi Form Dengan Benar');
        }

        $saldo = User::find(Auth::user()->id)->user_data->saldo;
        if ($saldo < $request->input('jumlah')) {
            return redirect()->back()->with('error', 'Gagal Melakukan Donasi, Saldo Anda Tidak Cukup');
        }

        $transaksi = Transaksi::create([
            'user_id' => Auth::user()->id,
            'jenis_transaksi' => 'masuk',
            'kategori_id' => 1,
            'jumlah' => $request->input('jumlah'),
            'keterangan' => 'Donasi Online',
            'status_transaksi' => 'selesai',
        ]);

        User::find(Auth::user()->id)->user_data->update([
            'saldo' => $saldo - $request->input('jumlah'),
        ]);
        return redirect()->back()->with([
            'confirmCetak' => 'Apakah Anda ingin mencetak bukti donasi?',
            'transaksi_id' => encrypt($transaksi->id),
        ]);
    }

    public function cetak($id = null)
    {
        try {
            if ($id) {
                $transaksi_id = decrypt($id);
                $transaksi = Transaksi::where('id', $transaksi_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

                return view('donasi.cetakDonasi', compact('transaksi'));
            }

            $donasi = Transaksi::where('user_id', Auth::id())
                ->orderBy('tanggal', 'desc')
                ->get();

            return view('donasi.exportDonasi', compact('donasi'));
        } catch (\Exception $e) {
            return redirect('/donasi')->with('error', 'Gagal mencetak data');
        }
    }

    public function addSaldo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saldo' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'saldo.required' => 'Jumlah saldo tidak boleh kosong',
            'saldo.numeric' => 'Jumlah saldo harus berupa angka',
            'gambar.required' => 'Bukti pembayaran tidak boleh kosong',
            'gambar.image' => 'Bukti pembayaran harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addSaldo', 'Gagal Menambahkan Saldo, Silahkan Isi Form Dengan Benar');
        }


        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('gambar')->store('bukti_pembayaran');
        }

        Transaksi::create([
            'user_id' => Auth::user()->id,
            'jenis_transaksi' => 'masuk',
            'kategori_id' => 2,
            'jumlah' => $request->input('saldo'),
            'keterangan' => 'Top Up Saldo',
            'gambar' => $image,
            'status_transaksi' => 'pending',
        ]);
        return redirect()->back()->with('success', 'Berhasil Menambahkan Saldo, Silahkan Menunggu Konfirmasi Admin');
    }
}
