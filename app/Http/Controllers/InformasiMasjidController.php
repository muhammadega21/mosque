<?php

namespace App\Http\Controllers;

use App\Models\InformasiMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InformasiMasjidController extends Controller
{
    // crud informasi masjid

    public function index()
    {
        return view('master.informasi', [
            'title' => "Informasi Masjid",
            'main_page' => '',
            'page' => 'Informasi',
            'informasi' => InformasiMasjid::orderBy('created_at', 'desc')->where('kategori', 'informasi')->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_post' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'tgl_post.required' => 'Tanggal Post wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'gambar.required' => 'Gambar wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addInformasi', 'Gagal Menambah Informasi');
        }

        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('gambar')->store('informasi_masjid');
        }

        $slug = Str::slug($request->input('judul'));

        InformasiMasjid::create([
            'tgl_post' => $request->input('tgl_post'),
            'judul' => $request->input('judul'),
            'slug' => $slug,
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => 'informasi',
            'gambar' => $image,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/informasi_masjid')->with('success', 'Berhasil Menambah Informasi');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_post' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'tgl_post.required' => 'Tanggal Post wajib diisi',
            'judul.required' => 'Judul wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateInformasi', 'Gagal Update Informasi');
        }

        $informasi = InformasiMasjid::findOrFail($id);

        $image = $request->oldImage;
        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('gambar')->store('informasi_masjid');
        }

        $slug = Str::slug($request->input('judul'));

        $informasi->update([
            'tgl_post' => $request->input('tgl_post'),
            'judul' => $request->input('judul'),
            'slug' => $slug,
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => 'informasi',
            'gambar' => $image,
        ]);

        return redirect('/informasi_masjid')->with('success', 'Berhasil Update Informasi');
    }

    public function destroy($id)
    {
        $informasi = InformasiMasjid::findOrFail($id);
        if ($informasi->gambar) {
            Storage::delete($informasi->gambar);
        }
        $informasi->delete();
        return redirect('/informasi_masjid')->with('success', 'Berhasil Menghapus Informasi');
    }
}
