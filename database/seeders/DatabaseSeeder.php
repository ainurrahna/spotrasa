<?php

namespace Database\Seeders;

use App\Models\CafeInfo;
use App\Models\Menu;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin
        User::create([
            'nama' => 'Admin Spotrasa',
            'email' => 'admin@spotrasa.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Akun pelanggan contoh
        $daftarPelanggan = collect([
            ['Budi Santoso', 'budi@spotrasa.test'],
            ['Siti Rahma', 'siti@spotrasa.test'],
            ['Andi Wijaya', 'andi@spotrasa.test'],
        ])->map(fn ($data) => User::create([
            'nama' => $data[0],
            'email' => $data[1],
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]))->values();

        // Informasi cafe (hanya satu baris). Bisa diubah lewat menu Kelola > Informasi cafe.
        $cafe = CafeInfo::create([
            'nama_cafe' => 'Spotrasa',
            'alamat' => 'Jl. Jakasampurna kp. dua',
            'jam_operasi' => '09.00 - 22.00',
            'deskripsi' => 'Temukan cita rasa favorit dan bagikan pengalaman kulinermu.',
            'no_telepon' => '085880419650',
        ]);

        // Daftar menu contoh
        $daftarMenu = collect([
            // Makanan
            ['nama_menu' => 'Nasi Goreng Spesial', 'kategori' => 'Makanan', 'harga' => 25000, 'deskripsi_menu' => 'Nasi goreng dengan telur mata sapi, ayam suwir, dan kerupuk.'],
            ['nama_menu' => 'Mie Ayam Bakso', 'kategori' => 'Makanan', 'harga' => 22000, 'deskripsi_menu' => 'Mie ayam dengan bakso sapi dan kuah kaldu hangat.'],
            ['nama_menu' => 'Ayam Geprek Sambal Matah', 'kategori' => 'Makanan', 'harga' => 24000, 'deskripsi_menu' => 'Ayam goreng tepung digeprek dengan sambal matah, disajikan dengan nasi.'],
            ['nama_menu' => 'Nasi Ayam Bakar', 'kategori' => 'Makanan', 'harga' => 27000, 'deskripsi_menu' => 'Ayam bakar bumbu kecap dengan nasi, lalapan, dan sambal terasi.'],

            // Minuman
            ['nama_menu' => 'Es Kopi Susu', 'kategori' => 'Minuman', 'harga' => 18000, 'deskripsi_menu' => 'Kopi susu dingin dengan gula aren.'],
            ['nama_menu' => 'Kopi Hitam', 'kategori' => 'Minuman', 'harga' => 12000, 'deskripsi_menu' => 'Kopi hitam panas tanpa gula, aroma kuat.'],
            ['nama_menu' => 'Es Teh Lemon', 'kategori' => 'Minuman', 'harga' => 12000, 'deskripsi_menu' => 'Teh dingin segar dengan perasan lemon.'],
            ['nama_menu' => 'Matcha Latte', 'kategori' => 'Minuman', 'harga' => 22000, 'deskripsi_menu' => 'Matcha dengan susu segar, bisa disajikan panas atau dingin.'],
            ['nama_menu' => 'Es Jeruk Segar', 'kategori' => 'Minuman', 'harga' => 13000, 'deskripsi_menu' => 'Perasan jeruk asli dengan es batu.'],

            // Dessert
            ['nama_menu' => 'Brownies Cokelat', 'kategori' => 'Dessert', 'harga' => 20000, 'deskripsi_menu' => 'Brownies lembut dengan saus cokelat hangat.'],
            ['nama_menu' => 'Pisang Goreng Keju', 'kategori' => 'Dessert', 'harga' => 15000, 'deskripsi_menu' => 'Pisang goreng renyah dengan parutan keju.'],
            ['nama_menu' => 'Pancake Madu', 'kategori' => 'Dessert', 'harga' => 21000, 'deskripsi_menu' => 'Pancake empuk dengan madu dan irisan buah.'],
        ])->map(function ($data) use ($cafe) {
            $data['id_cafe'] = $cafe->id_cafe;

            return Menu::create($data);
        })->values();

        // Review contoh supaya grafik dashboard tidak kosong
        $daftarRating = [5, 4, 5, 4, 3, 4, 5, 5, 4, 3, 4, 3, 4, 5, 5, 3, 3, 4];
        $daftarKomentar = [
            'Enak banget, porsinya pas.',
            'Rasanya mantap, pasti balik lagi.',
            'Lumayan, tapi agak lama disajikan.',
            'Favorit saya di sini.',
            'Biasa saja, tapi harganya masuk akal.',
        ];

        foreach ($daftarMenu as $urutanMenu => $menu) {
            foreach ($daftarPelanggan as $urutanPelanggan => $pelanggan) {
                $nomor = $urutanMenu * 3 + $urutanPelanggan;

                Review::create([
                    'id_user' => $pelanggan->id_user,
                    'id_menu' => $menu->id_menu,
                    'rating' => $daftarRating[$nomor % count($daftarRating)],
                    'komentar' => $daftarKomentar[$nomor % count($daftarKomentar)],
                    'status_moderasi' => Review::STATUS_DISETUJUI,
                    'tanggal_review' => now()->subMonths(($urutanMenu + $urutanPelanggan) % 5)->subDays($urutanPelanggan * 3),
                ]);
            }
        }
    }
}