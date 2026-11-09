@extends('layout.utama')

@section('judul', 'Ubah menu - Spotrasa')

@section('isi')
<div class="container page">
    <h1 class="page-title">Ubah menu</h1>

    <form method="POST" action="{{ route('admin.menu.perbarui', $menu) }}" enctype="multipart/form-data" class="panel" novalidate>
        @csrf
        @method('PUT')
        @include('admin.menu._formulir')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-brand">Simpan perubahan</button>
            <a href="{{ route('admin.menu.daftar') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection