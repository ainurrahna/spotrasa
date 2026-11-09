<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Spotrasa')</title>

    {{-- Ikon pada tab browser memakai logo yang sama --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('gambar/logo.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/spotrasa.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
        {{-- Logo: ke dashboard jika sudah login, ke halaman masuk jika belum --}}
        <a class="navbar-brand merek" href="{{ auth()->check() ? route('dashboard') : route('masuk') }}">
            <img class="merek-logo" src="{{ asset('gambar/logo.svg') }}" alt="" width="38" height="38">
            <span>Spotrasa</span>
        </a>

        {{-- Menu navigasi hanya ada setelah login --}}
        @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavigasi"
                    aria-controls="menuNavigasi" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuNavigasi">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 ikon-tombol"></i>Dashboard
                        </a>
                    </li>

                    {{-- Link Menu hanya untuk pelanggan --}}
                    @unless(auth()->user()->apakahAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('beranda', 'menu.detail') ? 'active' : '' }}" href="{{ route('beranda') }}">
                                <i class="bi bi-cup-hot ikon-tombol"></i>Menu
                            </a>
                        </li>
                    @endunless

                    @if(auth()->user()->apakahAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear ikon-tombol"></i>Kelola
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.menu.daftar') }}"><i class="bi bi-card-list ikon-tombol"></i>Kelola menu</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.cafe.ubah') }}"><i class="bi bi-shop ikon-tombol"></i>Informasi cafe</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.review.daftar') }}"><i class="bi bi-chat-square-text ikon-tombol"></i>Moderasi review</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <span class="nav-link nav-user"><i class="bi bi-person-circle ikon-tombol"></i>{{ auth()->user()->nama }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('keluar') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-box-arrow-right ikon-tombol"></i>Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>

<main>
    {{-- Pesan berhasil atau gagal --}}
    @if(session('berhasil') || session('gagal'))
        <div class="container pt-3">
            @if(session('berhasil'))
                <div class="alert alert-success mb-0" role="status">{{ session('berhasil') }}</div>
            @endif
            @if(session('gagal'))
                <div class="alert alert-danger mb-0" role="alert">{{ session('gagal') }}</div>
            @endif
        </div>
    @endif

    @yield('isi')
</main>

<footer class="site-footer">
    <div class="container">Spotrasa &copy; {{ date('Y') }}</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('skrip')
</body>
</html>