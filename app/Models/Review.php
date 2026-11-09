<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public const STATUS_DISETUJUI = 'disetujui';

    protected $table = 'review';

    protected $primaryKey = 'id_review';

    // Waktu review disimpan di kolom tanggal_review (sesuai ERD)
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_menu',
        'rating',
        'komentar',
        'foto_kunjungan',
        'status_moderasi',
        'tanggal_review',
    ];

    protected $casts = [
        'tanggal_review' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    // Hanya review yang sudah disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('status_moderasi', self::STATUS_DISETUJUI);
    }
}