@extends('layout.utama')

@section('judul', 'Daftar - Spotrasa')

@section('isi')
<div class="auth-halaman">
    <div class="container">
        <div class="auth-kartu row g-0">

            {{-- Panel kiri --}}
            <div class="col-lg-5 auth-sisi">
                <div class=d-flex align-items-center mb-3>
                    <img class="auth-logo me-2" src="{{ asset('gambar/logo.svg') }}" alt="Logo Spotrasa" style="width: 40px; height: 40px;">
                    <p class="auth-merek">Spotrasa</p>
               </div>
                <img
                    src="{{ asset('images/foto-cafe.jpeg') }}"
                    alt="Suasana kafe Spotrasa"
                    class="auth-foto"
                 >
            </div>

            {{-- Form daftar --}}
            <div class="col-lg-7 auth-isi">
                <h1 class="page-title">Buat akun</h1>
                <p class="text-secondary mb-4">Isi data di bawah untuk mulai memberi review.</p>

                <form method="POST" action="{{ route('daftar.proses') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               class="form-control @error('nama') is-invalid @enderror" required autofocus>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            <div class="form-text">Minimal 6 karakter.</div>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="konfirmasi_password" class="form-label">Ulangi password</label>
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                                   class="form-control @error('konfirmasi_password') is-invalid @enderror" required>
                            @error('konfirmasi_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-brand w-100">
                        <i class="bi bi-person-plus ikon-tombol"></i>Daftar
                    </button>
                </form>

                <p class="mt-4 mb-0">Sudah punya akun? <a href="{{ route('masuk') }}">Masuk</a></p>
            </div>

        </div>
    </div>
</div>
@endsection