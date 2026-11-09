<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Subrutin yang dipakai ulang: mengecilkan dan mengompres foto sebelum disimpan.
 * Hasilnya selalu berupa file JPEG dengan lebar maksimal $lebarMaks.
 */
trait UnggahFoto
{
    protected function kompresDanSimpanFoto(
        UploadedFile $berkas,
        string $folder,
        int $lebarMaks = 1024,
        int $kualitas = 80
    ): string {
        $lokasi = $berkas->getRealPath();
        $jenis = getimagesize($lokasi)['mime'] ?? '';

        $gambarAsli = match ($jenis) {
            'image/jpeg' => imagecreatefromjpeg($lokasi),
            'image/png'  => imagecreatefrompng($lokasi),
            'image/webp' => imagecreatefromwebp($lokasi),
            default      => throw new \InvalidArgumentException('Format gambar tidak didukung.'),
        };

        $lebar = imagesx($gambarAsli);
        $tinggi = imagesy($gambarAsli);

        // Kecilkan jika lebih lebar dari batas
        if ($lebar > $lebarMaks) {
            $lebarBaru = $lebarMaks;
            $tinggiBaru = (int) round($tinggi * $lebarMaks / $lebar);
        } else {
            $lebarBaru = $lebar;
            $tinggiBaru = $tinggi;
        }

        $kanvas = imagecreatetruecolor($lebarBaru, $tinggiBaru);

        // Latar putih supaya PNG transparan tidak menjadi hitam
        imagefill($kanvas, 0, 0, imagecolorallocate($kanvas, 255, 255, 255));
        imagecopyresampled($kanvas, $gambarAsli, 0, 0, 0, 0, $lebarBaru, $tinggiBaru, $lebar, $tinggi);

        ob_start();
        imagejpeg($kanvas, null, $kualitas);
        $isiFoto = ob_get_clean();

        imagedestroy($gambarAsli);
        imagedestroy($kanvas);

        $namaFile = $folder . '/' . uniqid('', true) . '.jpg';
        Storage::disk('public')->put($namaFile, $isiFoto);

        return $namaFile;
    }
}