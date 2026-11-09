@extends('layout.utama')

@section('judul', 'Informasi cafe - Spotrasa')

@section('isi')
<div class="container page">
    <h1 class="page-title">Informasi cafe</h1>

    <form method="POST" action="{{ route('admin.cafe.perbarui') }}" class="panel" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_cafe" class="form-label">Nama cafe</label>
            <input type="text" id="nama_cafe" name="nama_cafe" value="{{ old('nama_cafe', $cafe->nama_cafe) }}"
                   class="form-control @error('nama_cafe') is-invalid @enderror" required>
            @error('nama_cafe')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $cafe->alamat) }}"
                   class="form-control @error('alamat') is-invalid @enderror" required>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="jam_operasi" class="form-label">Jam operasi</label>
                <input type="text" id="jam_operasi" name="jam_operasi" value="{{ old('jam_operasi', $cafe->jam_operasi) }}"
                       class="form-control @error('jam_operasi') is-invalid @enderror" required>
                @error('jam_operasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_telepon" class="form-label">Nomor telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $cafe->no_telepon) }}"
                       class="form-control @error('no_telepon') is-invalid @enderror" required>
                @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $cafe->deskripsi) }}</textarea>
            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-brand">Simpan informasi</button>
    </form>
</div>
@endsection