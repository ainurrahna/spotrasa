<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Menu (sesuai ERD). Satu cafe memiliki banyak menu.
        Schema::create('menu', function (Blueprint $tabel) {
            $tabel->engine = 'InnoDB';
            $tabel->id('id_menu');
            $tabel->unsignedBigInteger('id_cafe');
            $tabel->string('nama_menu');
            $tabel->string('kategori');
            $tabel->integer('harga');
            $tabel->string('foto_menu')->nullable();
            $tabel->text('deskripsi_menu');

            $tabel->foreign('id_cafe')->references('id_cafe')->on('cafe_info')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};