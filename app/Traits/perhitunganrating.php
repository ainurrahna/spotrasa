<?php

namespace App\Traits;

/**
 * Subrutin yang dipakai ulang: menghitung rata-rata rating dan jumlah review.
 * Hanya review yang sudah disetujui yang dihitung.
 */
trait PerhitunganRating
{
    public function rataRataRating(): float
    {
        return round((float) $this->daftarReview()->disetujui()->avg('rating'), 1);
    }

    public function jumlahReview(): int
    {
        return $this->daftarReview()->disetujui()->count();
    }
}