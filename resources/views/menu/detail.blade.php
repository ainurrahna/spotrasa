@extends('layout.utama')

@section('judul', $menu->nama_menu . ' - Spotrasa')

@section('isi')
@php
    $rata = $menu->rataRataRating();
    $jumlah = $menu->jumlahReview();
@endphp
<div class="container page">
    <a href="{{ route('beranda') }}" class="d-inline-block mb-3"><i class="bi bi-arrow-left ikon-tombol"></i>Kembali ke daftar menu</a>

    <div class="row g-4 mb-5">
        <div class="col-lg-5">
            @if($menu->foto_menu)
                <img class="menu-photo rounded-3" src="{{ asset('storage/' . $menu->foto_menu) }}" alt="Foto {{ $menu->nama_menu }}">
            @else
                <div class="menu-photo placeholder rounded-3" aria-hidden="true"><i class="bi bi-cup-hot"></i></div>
            @endif
        </div>
        <div class="col-lg-7">
            <span class="kategori">{{ $menu->kategori }}</span>
            <h1 class="page-title mb-2">{{ $menu->nama_menu }}</h1>
            <div class="price fs-4 mb-3">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>

            <div class="mb-3 fs-5">
                @include('bagian.bintang', ['nilai' => $rata])
                @if($jumlah > 0)
                    <span class="ms-1">{{ number_format($rata, 1) }}</span>
                    <span class="text-secondary fs-6">dari {{ $jumlah }} review</span>
                @else
                    <span class="text-secondary fs-6">Belum ada review</span>
                @endif
            </div>

            <p style="max-width: 60ch">{{ $menu->deskripsi_menu }}</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Kolom kiri: form review --}}
        <div class="col-lg-5">
            <h2 class="section-title">Tulis review</h2>

            @auth
                @if($reviewSaya)
                    <div class="panel">
                        <p class="mb-2">
                            Kamu sudah memberi rating {{ $reviewSaya->rating }} dari 5 untuk menu ini.
                            @if($reviewSaya->status_moderasi === 'menunggu')
                                Review kamu sedang menunggu persetujuan admin sebelum tampil.
                            @endif
                        </p>
                        <form method="POST" action="{{ route('review.hapus', $reviewSaya) }}"
                              onsubmit="return confirm('Hapus review kamu untuk menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash ikon-tombol"></i>Hapus review saya
                            </button>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('review.simpan', $menu) }}" enctype="multipart/form-data" class="panel" novalidate>
                        @csrf

                        <div class="mb-3">
                            <span class="form-label d-block" id="labelRating">Rating</span>
                            <div class="star-input" role="radiogroup" aria-labelledby="labelRating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="bintang{{ $i }}" name="rating" value="{{ $i }}"
                                           {{ (int) old('rating') === $i ? 'checked' : '' }}>
                                    <label for="bintang{{ $i }}" title="{{ $i }} bintang">★<span class="visually-hidden">{{ $i }} bintang</span></label>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="komentar" class="form-label">Komentar (boleh kosong)</label>
                            <textarea id="komentar" name="komentar" rows="4"
                                      class="form-control @error('komentar') is-invalid @enderror"
                                      placeholder="Ceritakan pengalamanmu">{{ old('komentar') }}</textarea>
                            @error('komentar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_kunjungan" class="form-label"><i class="bi bi-camera ikon-tombol"></i>Foto kunjungan (boleh kosong)</label>
                            <input type="file" id="foto_kunjungan" name="foto_kunjungan" accept="image/jpeg,image/png,image/webp"
                                   class="form-control @error('foto_kunjungan') is-invalid @enderror">
                            <div class="form-text">JPG, PNG, atau WebP, maksimal 2 MB.</div>
                            @error('foto_kunjungan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-brand"><i class="bi bi-send ikon-tombol"></i>Kirim review</button>
                    </form>
                @endif
            @else
                <div class="panel">
                    <p class="mb-3">Masuk dulu untuk memberi rating dan review.</p>
                    <a href="{{ route('masuk') }}" class="btn btn-brand me-2">Masuk</a>
                    <a href="{{ route('daftar') }}" class="btn btn-outline-secondary">Daftar</a>
                </div>
            @endauth
        </div>

        {{-- Kolom kanan: daftar review --}}
        <div class="col-lg-7">
            <h2 class="section-title">Review pengunjung</h2>

            <div class="panel">
                @forelse($daftarReview as $review)
                    <div class="review">
                        <div class="d-flex justify-content-between flex-wrap gap-1">
                            <strong><i class="bi bi-person-circle ikon-tombol text-secondary"></i>{{ $review->pengguna->nama }}</strong>
                            <span class="text-secondary small">{{ $review->tanggal_review->format('d M Y') }}</span>
                        </div>
                        <div class="mb-1">@include('bagian.bintang', ['nilai' => $review->rating])</div>
                        @if($review->komentar)
                            <p class="mb-2">{{ $review->komentar }}</p>
                        @endif
                        @if($review->foto_kunjungan)
                            <a href="{{ asset('storage/' . $review->foto_kunjungan) }}" target="_blank" rel="noopener">
                                <img class="review-photo" src="{{ asset('storage/' . $review->foto_kunjungan) }}"
                                     alt="Foto kunjungan dari {{ $review->pengguna->nama }}" loading="lazy">
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="mb-0 text-secondary">Belum ada review untuk menu ini. Jadilah yang pertama menulis.</p>
                @endforelse
            </div>

            <div class="mt-3">{{ $daftarReview->links() }}</div>
        </div>
    </div>
</div>
@endsection