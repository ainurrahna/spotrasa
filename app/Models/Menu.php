<?php

namespace App\Models;

use App\Traits\PerhitunganRating;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use PerhitunganRating;

    public const DAFTAR_KATEGORI = ['Makanan', 'Minuman', 'Dessert'];

    protected $table = 'menu';

    protected $primaryKey = 'id_menu';

    public $timestamps = false;

    protected $fillable = [
        'id_cafe',
        'nama_menu',
        'kategori',
        'harga',
        'foto_menu',
        'deskripsi_menu',
    ];

    public function cafeInfo()
    {
        return $this->belongsTo(CafeInfo::class, 'id_cafe', 'id_cafe');
    }

    // Satu menu memiliki banyak review
    public function daftarReview()
    {
        return $this->hasMany(Review::class, 'id_menu', 'id_menu');
    }
}