<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AutentikasiController extends Controller
{
    // Menampilkan halaman masuk
    public function formMasuk()
    {
        return view('autentikasi.masuk');
    }

    // Memproses login
    public function prosesMasuk(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    // Menampilkan halaman daftar akun
    public function formDaftar()
    {
        return view('autentikasi.daftar');
    }

    // Memproses pendaftaran akun pelanggan
    public function prosesDaftar(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:user,email'],
            'password' => ['required', 'min:6'],
            'konfirmasi_password' => ['required', 'same:password'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 150 karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'konfirmasi_password.required' => 'Ulangi password wajib diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password tidak sama.',
        ]);

        $pengguna = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'pelanggan',
        ]);

        Auth::login($pengguna);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('berhasil', 'Akun berhasil dibuat. Selamat datang di Spotrasa!');
    }

    // Keluar (logout)
    public function keluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('masuk');
    }
}