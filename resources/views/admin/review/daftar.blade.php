@extends('layout.utama')

@section('judul', 'Moderasi review - Spotrasa')

@section('isi')
<div class="container page">
    <h1 class="page-title">Moderasi review</h1>


    {{-- Saringan review --}}
    <form method="GET" action="{{ route('admin.review.daftar') }}" class="panel mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label for="menu" class="form-label">Menu</label>
                <select id="menu" name="menu" class="form-select">
                    <option value="">Semua menu</option>
                    @foreach($daftarMenu as $menu)
                        <option value="{{ $menu->id_menu }}" {{ (string) $idMenu === (string) $menu->id_menu ? 'selected' : '' }}>
                            {{ $menu->nama_menu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="rating" class="form-label">Rating</label>
                <select id="rating" name="rating" class="form-select">
                    <option value="">Semua rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (string) $rating === (string) $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-brand flex-fill"><i class="bi bi-funnel ikon-tombol"></i>Saring</button>
                <a href="{{ route('admin.review.daftar') }}" class="btn btn-outline-secondary">Atur ulang</a>
            </div>
        </div>
    </form>

    <p class="text-secondary small mb-2">Menampilkan {{ $daftarReview->total() }} review</p>

    <div class="panel p-0 table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Pengguna</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Komentar</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarReview as $review)
                    <tr>
                        <td>{{ $review->pengguna->nama }}</td>
                        <td>{{ $review->menu->nama_menu }}</td>
                        <td>@include('bagian.bintang', ['nilai' => $review->rating])</td>
                        <td style="min-width: 200px">{{ \Illuminate\Support\Str::limit($review->komentar, 80) ?: '-' }}</td>
                        <td>
                            @if($review->foto_kunjungan)
                                <a href="{{ asset('storage/' . $review->foto_kunjungan) }}" target="_blank" rel="noopener">
                                    <img class="thumb" src="{{ asset('storage/' . $review->foto_kunjungan) }}" alt="Foto kunjungan">
                                </a>
                            @else
                                <span class="text-secondary">-</span>
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $review->tanggal_review->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Tidak ada review yang sesuai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $daftarReview->links() }}</div>
</div>
@endsection