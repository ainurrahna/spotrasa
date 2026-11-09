<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';

    protected $primaryKey = 'id_user';

    // Tabel user di ERD tidak punya created_at dan updated_at
    public $timestamps = false;

    // Tabel user di ERD tidak punya kolom remember_token
    protected $rememberTokenName = '';

    protected $fillable = ['nama', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    // Satu user memberikan banyak review
    public function daftarReview()
    {
        return $this->hasMany(Review::class, 'id_user', 'id_user');
    }

    public function apakahAdmin(): bool
    {
        return $this->role === 'admin';
    }
}