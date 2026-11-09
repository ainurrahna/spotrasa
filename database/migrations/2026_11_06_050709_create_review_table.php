<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Review (sesuai ERD). User memberikan banyak review, menu memiliki banyak review.
        Schema::create('review', function (Blueprint $tabel) {
            $tabel->engine = 'InnoDB';
            $tabel->id('id_review');
            $tabel->unsignedBigInteger('id_user');
            $tabel->unsignedBigInteger('id_menu');
            $tabel->integer('rating');
            $tabel->text('komentar')->nullable();
            $tabel->string('foto_kunjungan')->nullable();
            $tabel->string('status_moderasi')->default('disetujui');
            $tabel->timestamp('tanggal_review')->useCurrent();

            $tabel->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $tabel->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};