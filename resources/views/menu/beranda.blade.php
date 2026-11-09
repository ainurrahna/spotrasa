@extends('layout.utama')

@section('judul', ($cafe?->nama_cafe ?? 'Spotrasa') . ' - Menu')

@section('isi')
<section class="hero">
    <div class="container">
        <h1 class="hero-title">{{ $cafe?->nama_cafe ?? 'Spotrasa' }}</h1>

        @if($cafe)
            <p class="hero-lead">{{ $cafe->deskripsi }}</p>

            <dl class="hero-info">
                <div><dt><i class="bi bi-geo-alt"></i>Alamat</dt><dd>{{ $cafe->alamat }}</dd></div>
                <div><dt><i class="bi bi-clock"></i>Jam buka</dt><dd>{{ $cafe->jam_operasi }}</dd></div>
                <div><dt><i class="bi bi-telephone"></i>Telepon</dt><dd>{{ $cafe->no_telepon }}</dd></div>
            </dl>
        @endif
    </div>
</section>

<section class="container filter-bar">
    {{-- Form pencarian menu --}}
    <form method="GET" action="{{ route('beranda') }}" class="row g-2 mb-3" role="search">
        @if($kategori)<input type="hidden" name="kategori" value="{{ $kategori }}">@endif
        <div class="col-sm-9 col-md-10">
            <label for="cari" class="visually-hidden">Cari menu</label>
            <input type="search" id="cari" name="cari" value="{{ $kataKunci }}" class="form-control"
                   placeholder="Cari nama menu atau deskripsi">
        </div>
        <div class="col-sm-3 col-md-2 d-grid">
            <button type="submit" class="btn btn-brand"><i class="bi bi-search ikon-tombol"></i>Cari menu</button>
        </div>
    </form>

    {{-- Pilihan kategori --}}
    <div class="d-flex flex-wrap gap-2">
        <a class="pill {{ $kategori ? '' : 'active' }}" href="{{ route('beranda', array_filter(['cari' => $kataKunci])) }}">Semua</a>
        @foreach($daftarKategori as $namaKategori)
            <a class="pill {{ $kategori === $namaKategori ? 'active' : '' }}"
               href="{{ route('beranda', array_filter(['cari' => $kataKunci, 'kategori' => $namaKategori])) }}">{{ $namaKategori }}</a>
        @endforeach
    </div>
</section>

<section class="container pb-4">
    @if($daftarMenu->count())
        <div class="row g-4">
            @foreach($daftarMenu as $menu)
                @php
                    $rata = $menu->rataRataRating();
                    $jumlah = $menu->jumlahReview();
                @endphp
                <div class="col-sm-6 col-lg-4">
                    <article class="menu-card">
                        @if($menu->foto_menu)
                            <img class="menu-photo" src="{{ asset('storage/' . $menu->foto_menu) }}"
                                 alt="Foto {{ $menu->nama_menu }}" loading="lazy">
                        @else
                            <div class="menu-photo placeholder" aria-hidden="true"><i class="bi bi-cup-hot"></i></div>
                        @endif
                        <div class="menu-body">
                            <span class="kategori">{{ $menu->kategori }}</span>
                            <h2 class="menu-name">
                                <a href="{{ route('menu.detail', $menu) }}" class="stretched-link">{{ $menu->nama_menu }}</a>
                            </h2>
                            <div class="price mb-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                            <div class="menu-meta">
                                @include('bagian.bintang', ['nilai' => $rata])
                                @if($jumlah > 0)
                                    {{ number_format($rata, 1) }} dari {{ $jumlah }} review
                                @else
                                    Belum ada review
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $daftarMenu->links() }}</div>
    @else
        <div class="panel text-center">
            <p class="mb-2"><i class="bi bi-search fs-3 text-secondary"></i></p>
            <p class="mb-2"><strong>Menu tidak ditemukan.</strong></p>
            <p class="mb-3 text-secondary">Coba kata kunci lain atau tampilkan semua menu.</p>
            <a href="{{ route('beranda') }}" class="btn btn-brand">Tampilkan semua menu</a>
        </div>
    @endif
</section>
@endsection