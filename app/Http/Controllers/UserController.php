<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // crud jamaah dan profile

    public function index()
    {
        return view('master.jamaah', [
            'title' => "Donatur",
            'main_page' => '',
            'page' => 'Donatur',
            'jamaah' => User::where('role', 'jamaah')->orderBy('created_at', 'desc')->paginate(15),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
            'nama' => 'required|min:3|max:50',
            'nomor_hp' => 'required',
            'alamat' => 'required',
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

            'nomor_hp.required' => 'Nomor HP wajib diisi',

            'alamat.required' => 'Alamat wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('addJamaah', 'Gagal Menambah Jamaah');
        }

        $user = User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        UserData::create([
            'user_id' => $user->id,
            'nama' => $request->input('nama'),
            'nomor_hp' => $request->input('nomor_hp'),
            'alamat' => $request->input('alamat'),
        ]);

        return redirect('/jamaah')->with('success', 'Berhasil menambah Jamaah');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3|max:50',
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 50 karakter',

            'nomor_hp.required' => 'Nomor HP wajib diisi',

            'alamat.required' => 'Alamat wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('updateJamaah', 'Gagal Update Jamaah');
        }

        UserData::where('id', $id)->update([
            'nama' => $request->input('nama'),
            'nomor_hp' => $request->input('nomor_hp'),
            'alamat' => $request->input('alamat'),
        ]);
        return redirect('/jamaah')->with('success', 'Berhasil Update Jamaah');
    }

    public function destroy(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            UserData::where('user_id', $id)->delete();
            return redirect('/jamaah')->with('success', 'Berhasil Menghapus Jamaah');
        } else {
            return redirect('/jamaah')->with('error', 'Jamaah tidak ditemukan');
        }
    }
}
