<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Review;
use App\Traits\UnggahFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    use UnggahFoto;

    // Menyimpan review dan rating dari pelanggan
    public function simpan(Request $request, Menu $menu)
    {
        $idUser = $request->user()->id_user;

        // Satu pelanggan hanya boleh memberi satu review per menu
        if ($menu->daftarReview()->where('id_user', $idUser)->exists()) {
            return back()->with('gagal', 'Kamu sudah memberi review untuk menu ini. Hapus review lama jika ingin menulis ulang.');
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['nullable', 'max:1000'],
            'foto_kunjungan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'rating.required' => 'Pilih rating bintang dulu.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.between' => 'Rating harus antara 1 sampai 5.',
            'komentar.max' => 'Komentar maksimal 1000 karakter.',
            'foto_kunjungan.image' => 'File harus berupa gambar.',
            'foto_kunjungan.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'foto_kunjungan.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Foto dikecilkan dan dikompres dulu sebelum disimpan
        $fotoKunjungan = $request->hasFile('foto_kunjungan')
            ? $this->kompresDanSimpanFoto($request->file('foto_kunjungan'), 'review')
            : null;

        // Review langsung tampil, rating menu otomatis ikut berubah
        Review::create([
            'id_user' => $idUser,
            'id_menu' => $menu->id_menu,
            'rating' => $data['rating'],
            'komentar' => $data['komentar'] ?? null,
            'foto_kunjungan' => $fotoKunjungan,
            'status_moderasi' => Review::STATUS_DISETUJUI,
        ]);

        return redirect()->route('menu.detail', $menu)
            ->with('berhasil', 'Review kamu berhasil dikirim.');
    }

    // Pelanggan menghapus review miliknya sendiri
    public function hapus(Request $request, Review $review)
    {
        abort_unless((int) $review->id_user === (int) $request->user()->id_user, 403);

        $menu = $review->menu;

        if ($review->foto_kunjungan) {
            Storage::disk('public')->delete($review->foto_kunjungan);
        }

        $review->delete();

        return redirect()->route('menu.detail', $menu)->with('berhasil', 'Review kamu sudah dihapus.');
    }
}