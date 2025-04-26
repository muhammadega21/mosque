<?php

namespace App\Http\Controllers;

use App\Models\InformasiMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    // crud kegiatan

    public function index()
    {
        return view('master.kegiatan', [
            'title' => "Kegiatan Masjid",
            'main_page' => '',
            'page' => 'Kegiatan',
            'kegiatan' => InformasiMasjid::orderBy('created_at', 'desc')->where('kategori', 'kegiatan')->paginate(20),
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
            return redirect()->back()->withErrors($validator)->withInput()->with('addKegiatan', 'Gagal Menambah Kegiatan');
        }

        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('gambar')->store('kegiatan_masjid');
        }

        $slug = Str::slug($request->input('judul'));

        InformasiMasjid::create([
            'tgl_post' => $request->input('tgl_post'),
            'judul' => $request->input('judul'),
            'slug' => $slug,
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => 'kegiatan',
            'gambar' => $image,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/kegiatan_masjid')->with('success', 'Berhasil Menambah Kegiatan');
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
            return redirect()->back()->withErrors($validator)->withInput()->with('updateKegiatan', 'Gagal Update Kegiatan');
        }

        $kegiatan = InformasiMasjid::findOrFail($id);

        $image = $request->oldImage;
        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $image = $request->file('gambar')->store('kegiatan_masjid');
        }

        $slug = Str::slug($request->input('judul'));

        $kegiatan->update([
            'tgl_post' => $request->input('tgl_post'),
            'judul' => $request->input('judul'),
            'slug' => $slug,
            'deskripsi' => $request->input('deskripsi'),
            'kategori' => 'kegiatan',
            'gambar' => $image,
        ]);

        return redirect('/kegiatan_masjid')->with('success', 'Berhasil Update Kegiatan');
    }

    public function destroy($id)
    {
        $kegiatan = InformasiMasjid::findOrFail($id);
        if ($kegiatan->gambar) {
            Storage::delete($kegiatan->gambar);
        }
        $kegiatan->delete();
        return redirect('/kegiatan_masjid')->with('success', 'Berhasil Menghapus Kegiatan');
    }
}
