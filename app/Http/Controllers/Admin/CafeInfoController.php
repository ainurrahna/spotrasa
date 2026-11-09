<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeInfo;
use Illuminate\Http\Request;

class CafeInfoController extends Controller
{
    // Form ubah informasi cafe
    public function ubah()
    {
        $cafe = CafeInfo::firstOrFail();

        return view('admin.cafe.ubah', compact('cafe'));
    }

    // Menyimpan perubahan informasi cafe
    public function perbarui(Request $request)
    {
        $data = $request->validate([
            'nama_cafe' => ['required', 'max:100'],
            'alamat' => ['required', 'max:255'],
            'jam_operasi' => ['required', 'max:100'],
            'deskripsi' => ['required', 'max:1000'],
            'no_telepon' => ['required', 'max:20'],
        ], [
            'nama_cafe.required' => 'Nama cafe wajib diisi.',
            'nama_cafe.max' => 'Nama cafe maksimal 100 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'jam_operasi.required' => 'Jam operasi wajib diisi.',
            'jam_operasi.max' => 'Jam operasi maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
        ]);

        CafeInfo::firstOrFail()->update($data);

        return redirect()->route('admin.cafe.ubah')->with('berhasil', 'Informasi cafe berhasil disimpan.');
    }
}