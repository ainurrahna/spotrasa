@extends('layout.utama')

@section('judul', 'Kelola menu - Spotrasa')

@section('isi')
<div class="container page">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h1 class="page-title mb-0">Kelola menu</h1>
        <a href="{{ route('admin.menu.tambah') }}" class="btn btn-brand"><i class="bi bi-plus-lg ikon-tombol"></i>Tambah menu</a>
    </div>

    <div class="panel p-0 table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama menu</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Rating</th>
                    <th scope="col" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftarMenu as $menu)
                    @php $jumlah = $menu->jumlahReview(); @endphp
                    <tr>
                        <td>
                            @if($menu->foto_menu)
                                <img class="thumb" src="{{ asset('storage/' . $menu->foto_menu) }}" alt="Foto {{ $menu->nama_menu }}">
                            @else
                                <div class="thumb d-flex align-items-center justify-content-center" aria-hidden="true"><i class="bi bi-cup-hot"></i></div>
                            @endif
                        </td>
                        <td>{{ $menu->nama_menu }}</td>
                        <td>{{ $menu->kategori }}</td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($jumlah > 0)
                                {{ number_format($menu->rataRataRating(), 1) }} ({{ $jumlah }} review)
                            @else
                                <span class="text-secondary">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.menu.ubah', $menu) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-pencil-square ikon-tombol"></i>Ubah
                            </a>
                            <form method="POST" action="{{ route('admin.menu.hapus', $menu) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus menu {{ addslashes($menu->nama_menu) }}? Semua review menu ini ikut terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash ikon-tombol"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada menu. Tambahkan menu pertama Spotrasa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $daftarMenu->links() }}</div>
</div>
@endsection