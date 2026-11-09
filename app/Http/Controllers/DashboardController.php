<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function tampilkan()
    {
        // Jumlah seluruh review
        $totalReview = Review::disetujui()->count();

        // Hitung rata-rata rating tiap menu, lalu ambil 5 yang tertinggi
        $menuTerfavorit = Menu::all()
            ->map(function ($menu) {
                $menu->rata_rata = $menu->rataRataRating();
                $menu->jumlah = $menu->jumlahReview();
                return $menu;
            })
            ->filter(fn ($menu) => $menu->jumlah > 0)
            ->sortByDesc('rata_rata')
            ->take(5)
            ->values();

        $labelMenu = $menuTerfavorit->pluck('nama_menu')->all();
        $dataMenu = $menuTerfavorit->pluck('rata_rata')->all();

        // Sebaran rating: berapa review untuk bintang 1 sampai 5
        $sebaranRating = [];
        for ($bintang = 1; $bintang <= 5; $bintang++) {
            $sebaranRating[] = Review::disetujui()->where('rating', $bintang)->count();
        }

        // Jumlah review per bulan selama 6 bulan terakhir
        $labelBulan = [];
        $dataBulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->startOfMonth()->subMonths($i);

            $labelBulan[] = $bulan->copy()->locale('id')->translatedFormat('M Y');
            $dataBulan[] = Review::disetujui()
                ->whereYear('tanggal_review', $bulan->year)
                ->whereMonth('tanggal_review', $bulan->month)
                ->count();
        }

        // Ringkasan angka khusus admin
        $ringkasan = null;
        if (auth()->user()->apakahAdmin()) {
            $ringkasan = [
                'menu' => Menu::count(),
                'review' => Review::count(),
                'bulan_ini' => Review::disetujui()
                    ->whereYear('tanggal_review', now()->year)
                    ->whereMonth('tanggal_review', now()->month)
                    ->count(),
                'pelanggan' => User::where('role', 'pelanggan')->count(),
            ];
        }

        return view('dashboard', compact(
            'totalReview', 'menuTerfavorit', 'labelMenu', 'dataMenu',
            'sebaranRating', 'labelBulan', 'dataBulan', 'ringkasan'
        ));
    }
}