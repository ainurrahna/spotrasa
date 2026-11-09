<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeInfo extends Model
{
    protected $table = 'cafe_info';

    protected $primaryKey = 'id_cafe';

    public $timestamps = false;

    protected $fillable = ['nama_cafe', 'alamat', 'jam_operasi', 'deskripsi', 'no_telepon'];

    // Satu cafe memiliki banyak menu
    public function daftarMenu()
    {
        return $this->hasMany(Menu::class, 'id_cafe', 'id_cafe');
    }
}