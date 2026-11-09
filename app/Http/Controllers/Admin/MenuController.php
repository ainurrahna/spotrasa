<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeInfo;
use App\Models\Menu;
use App\Traits\UnggahFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    use UnggahFoto;

    // Daftar semua menu
    public function daftar()
    {
        $daftarMenu = Menu::orderByDesc('id_menu')->paginate(10);

        return view('admin.menu.daftar', compact('daftarMenu'));
    }

    // Form tambah menu
    public function tambah()
    {
        return view('admin.menu.tambah', ['daftarKategori' => Menu::DAFTAR_KATEGORI]);
    }

    // Menyimpan menu baru
    public function simpan(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        // Hanya ada satu cafe (Spotrasa), jadi menu otomatis milik cafe itu
        $data['id_cafe'] = CafeInfo::firstOrFail()->id_cafe;

       if ($request->hasFile('foto_menu')) {
    // Tambahkan pengecekan isset atau pastikan variabel $menu ada dan punya foto
    if (isset($menu) && $menu->foto_menu) {
        Storage::disk('public')->delete($menu->foto_menu);
    }

    $data['foto_menu'] = $this->kompresDanSimpanFoto(
        $request->file('foto_menu'),
        'menu'
    );
}

        Menu::create($data);

        return redirect()->route('admin.menu.daftar')->with('berhasil', 'Menu berhasil ditambahkan.');
    }

    // Form ubah menu
    public function ubah(Menu $menu)
    {
        return view('admin.menu.ubah', [
            'menu' => $menu,
            'daftarKategori' => Menu::DAFTAR_KATEGORI,
        ]);
    }

    // Menyimpan perubahan menu
    public function perbarui(Request $request, Menu $menu)
    {
        $data = $request->validate($this->aturan(), $this->pesan());

        if ($request->hasFile('foto_menu')) {
            // Hapus foto lama, simpan foto baru
            if ($menu->foto_menu) {
                Storage::disk('public')->delete($menu->foto_menu);
            }
            $data['foto_menu'] = $this->kompresDanSimpanFoto($request->file('foto_menu'), 'menu');
        } else {
            unset($data['foto_menu']);
        }

        $menu->update($data);

        return redirect()->route('admin.menu.daftar')->with('berhasil', 'Menu berhasil diperbarui.');
    }

    // Menghapus menu
    public function hapus(Menu $menu)
    {
        if ($menu->foto_menu) {
            Storage::disk('public')->delete($menu->foto_menu);
        }

        // Hapus juga foto kunjungan dari review menu ini
        foreach ($menu->daftarReview as $review) {
            if ($review->foto_kunjungan) {
                Storage::disk('public')->delete($review->foto_kunjungan);
            }
        }

        $menu->delete();

        return redirect()->route('admin.menu.daftar')->with('berhasil', 'Menu berhasil dihapus.');
    }

    private function aturan(): array
    {
        return [
            'nama_menu' => ['required', 'max:100'],
            'kategori' => ['required', Rule::in(Menu::DAFTAR_KATEGORI)],
            'harga' => ['required', 'integer', 'min:0', 'max:10000000'],
            'deskripsi_menu' => ['required', 'max:1000'],
            'foto_menu' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function pesan(): array
    {
        return [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'nama_menu.max' => 'Nama menu maksimal 100 karakter.',
            'kategori.required' => 'Pilih kategori menu.',
            'kategori.in' => 'Kategori tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'harga.max' => 'Harga terlalu besar.',
            'deskripsi_menu.required' => 'Deskripsi menu wajib diisi.',
            'deskripsi_menu.max' => 'Deskripsi menu maksimal 1000 karakter.',
            'foto_menu.image' => 'File harus berupa gambar.',
            'foto_menu.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'foto_menu.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}