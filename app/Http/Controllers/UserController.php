<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // crud pengurus

    public function index()
    {
        return view('master.pengurus', [
            'title' => "Pengurus",
            'main_page' => '',
            'page' => 'Pengurus',
            'pengurus' => User::orderBy('created_at', 'desc')->paginate(15),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
            'nama' => 'required|min:3|max:50',
            'username' => 'required|min:3|max:15',
            'nomor_hp' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 4 karakter',

            'confirm_password.required' => 'Konfirmasi Password wajib diisi',
            'confirm_password.same' => 'Konfirmasi Password tidak sama',

            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 50 karakter',

            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 15 karakter',

            'nomor_hp.required' => 'Nomor HP wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addPengurus', 'Gagal Menambah Pengurus');
        }

        User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'nomor_hp' => $request->input('nomor_hp'),
        ]);

        return redirect('/pengurus')->with('success', 'Berhasil menambah Pengurus');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:50',
            'username' => 'required|min:3|max:15',
            'nomor_hp' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 50 karakter',

            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 15 karakter',

            'nomor_hp.required' => 'Nomor HP wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updatePengurus', 'Gagal Update Pengurus');
        }

        User::where('id', $id)->update([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'nomor_hp' => $request->input('nomor_hp'),
        ]);
        return redirect('/pengurus')->with('success', 'Berhasil Update Pengurus');
    }

    public function destroy(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('/pengurus')->with('success', 'Berhasil Menghapus Pengurus');
        } else {
            return redirect('/pengurus')->with('error', 'Pengurus tidak ditemukan');
        }
    }
}
