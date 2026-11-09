@extends('layout.utama')

@section('judul', 'Masuk - Spotrasa')

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

            {{-- Form masuk --}}
            <div class="col-lg-7 auth-isi">
                <h1 class="page-title">Masuk</h1>
                <p class="text-secondary mb-4">Masuk untuk melihat menu dan memberi review.</p>

                <form method="POST" action="{{ route('masuk.proses') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-brand w-100">
                        <i class="bi bi-box-arrow-in-right ikon-tombol"></i>Masuk
                    </button>
                </form>

                <p class="mt-4 mb-0">Belum punya akun? <a href="{{ route('daftar') }}">Daftar sekarang</a></p>
            </div>

        </div>
    </div>
</div>
@endsection