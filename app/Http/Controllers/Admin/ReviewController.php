<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function daftar(Request $request)
    {
        $idMenu = $request->query('menu');
        $rating = $request->query('rating');

        $query = Review::with(['pengguna', 'menu']);

        // Saring berdasarkan menu
        if ($request->filled('menu')) {
            $query->where('id_menu', (int) $idMenu);
        }

        // Saring berdasarkan rating bintang
        if (in_array($rating, ['1', '2', '3', '4', '5'], true)) {
            $query->where('rating', (int) $rating);
        }

        // Ambil data review dari database, terbaru di atas
        $daftarReview = $query
            ->orderByDesc('tanggal_review')
            ->paginate(10)
            ->withQueryString();

        // Daftar menu untuk pilihan saringan
        $daftarMenu = Menu::orderBy('nama_menu')->get();

        return view('admin.review.daftar', compact('daftarReview', 'daftarMenu', 'idMenu', 'rating'));
    }
}