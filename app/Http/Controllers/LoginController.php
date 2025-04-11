<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('toastSuccess', 'Selamat Datang ' . Auth::user()->user_data->nama);
        }

        return back()->with('error', 'Email atau Password Salah');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:30',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'nomor_hp' => 'required|numeric',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong!',
            'nama.max' => 'Nama Maksimal 30 Character!',
            'email.required' => 'Email Tidak Boleh Kosong!',
            'email.email' => 'Email Harus Berupa Email Yang Benar!',
            'email.unique' => 'Email Sudah Ada!',
            'password.required' => 'Password Tidak Boleh Kosong!',
            'password.min' => 'Password Minimal 4 Character!',
            'password.confirmed' => 'Password Confirmation Harus Sama Dengan Password!',
            'nomor_hp.required' => 'Nomor HP Tidak Boleh Kosong!',
            'nomor_hp.numeric' => 'Nomor HP Harus Berupa Angka!',
            'alamat.required' => 'Alamat Tidak Boleh Kosong!',
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        UserData::create([
            'user_id' => $user->id,
            'nama' => $validatedData['nama'],
            'nomor_hp' => $validatedData['nomor_hp'],
            'alamat' => $validatedData['alamat'],
        ]);

        return redirect('/login')->with('success', 'Berhasil mendaftar, silahkan login');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil Logout');
    }
}
