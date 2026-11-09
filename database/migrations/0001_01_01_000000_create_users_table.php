<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel User (sesuai ERD)
        Schema::create('user', function (Blueprint $tabel) {
            $tabel->engine = 'InnoDB';
            $tabel->id('id_user');
            $tabel->string('nama');
            $tabel->string('email')->unique();
            $tabel->string('password');
            $tabel->enum('role', ['admin', 'pelanggan'])->default('pelanggan');
        });

        // Tabel sessions: wajib ada karena .env memakai SESSION_DRIVER=database
        Schema::create('sessions', function (Blueprint $tabel) {
            $tabel->string('id')->primary();
            $tabel->foreignId('user_id')->nullable()->index();
            $tabel->string('ip_address', 45)->nullable();
            $tabel->text('user_agent')->nullable();
            $tabel->longText('payload');
            $tabel->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user');
    }
};