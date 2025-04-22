<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // crud kategori

    public function index()
    {
        return view('master.kategori', [
            'title' => "Kategori",
            'main_page' => '',
            'page' => 'Kategori',
            'kategori' => Kategori::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|min:3|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama Kategori wajib diisi',
            'nama_kategori.min' => 'Nama Kategori minimal 3 karakter',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addKategori', 'Gagal Menambah Kategori');
        }

        Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
        ]);

        return redirect('/kategori')->with('success', 'Berhasil menambah Kategori');
    }

    public function update(Request $request, int $id)
    {
        $data = Kategori::find($id);
        if (!$data) {
            return redirect('/kategori')->with('error', 'Kategori tidak ditemukan');
        }
        $rules = [];
        if ($request->nama_kategori != $data->nama_kategori) {
            $rules['nama_kategori'] = 'required|min:3|unique:kategori,nama_kategori';
        }
        $validator = Validator::make($request->all(), $rules, [
            'nama_kategori.required' => 'Nama Kategori wajib diisi',
            'nama_kategori.min' => 'Nama Kategori minimal 3 karakter',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateKategori', 'Gagal Update Kategori');
        }

        Kategori::where('id', $id)->update([
            'nama_kategori' => $request->input('nama_kategori'),
        ]);
        return redirect('/kategori')->with('success', 'Berhasil Update Kategori');
    }

    public function destroy(int $id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Berhasil Menghapus Kategori');
        } else {
            return redirect('/kategori')->with('error', 'Kategori tidak ditemukan');
        }
    }
}
