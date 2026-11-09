<?php

namespace App\Http\Controllers;

use App\Models\CafeInfo;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Halaman utama: info cafe, pencarian menu, dan daftar menu
    public function beranda(Request $request)
    {
        $cafe = CafeInfo::first();
        $daftarKategori = Menu::DAFTAR_KATEGORI;
        $kataKunci = trim((string) $request->query('cari', ''));
        $kategori = $request->query('kategori');

        $query = Menu::query();

        // Cari berdasarkan nama atau deskripsi menu
        if ($kataKunci !== '') {
            $query->where(function ($q) use ($kataKunci) {
                $q->where('nama_menu', 'like', "%{$kataKunci}%")
                  ->orWhere('deskripsi_menu', 'like', "%{$kataKunci}%");
            });
        }

        // Filter berdasarkan kategori
        if (in_array($kategori, $daftarKategori, true)) {
            $query->where('kategori', $kategori);
        }

        $daftarMenu = $query->orderByDesc('id_menu')->paginate(9)->withQueryString();

        return view('menu.beranda', compact('cafe', 'daftarMenu', 'daftarKategori', 'kataKunci', 'kategori'));
    }

    // Halaman detail menu beserta review-nya
    public function detail(Menu $menu)
    {
        // Hanya review yang sudah disetujui admin yang tampil
        $daftarReview = $menu->daftarReview()
            ->disetujui()
            ->with('pengguna')
            ->orderByDesc('tanggal_review')
            ->paginate(5);

        // Review milik pengguna yang sedang login (jika ada)
        $reviewSaya = auth()->check()
            ? $menu->daftarReview()->where('id_user', auth()->id())->first()
            : null;

        return view('menu.detail', compact('menu', 'daftarReview', 'reviewSaya'));
    }
}