<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    
    {
        // Tabel Cafe_info (sesuai ERD)
        Schema::create('cafe_info', function (Blueprint $tabel) {
            $tabel->engine = 'InnoDB';
            $tabel->id('id_cafe');
            $tabel->string('nama_cafe');
            $tabel->text('alamat');
            $tabel->string('jam_operasi');
            $tabel->text('deskripsi');
            $tabel->string('no_telepon', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafe_info');
    }
};