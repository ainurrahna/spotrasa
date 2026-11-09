<div class="mb-3">
    <label for="nama_menu" class="form-label">Nama menu</label>
    <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu ?? '') }}"
           class="form-control @error('nama_menu') is-invalid @enderror" required>
    @error('nama_menu')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
            <option value="">Pilih kategori</option>
            @foreach($daftarKategori as $namaKategori)
                <option value="{{ $namaKategori }}" {{ old('kategori', $menu->kategori ?? '') === $namaKategori ? 'selected' : '' }}>{{ $namaKategori }}</option>
            @endforeach
        </select>
        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="harga" class="form-label">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" min="0" step="500" value="{{ old('harga', $menu->harga ?? '') }}"
               class="form-control @error('harga') is-invalid @enderror" required>
        @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label for="deskripsi_menu" class="form-label">Deskripsi menu</label>
    <textarea id="deskripsi_menu" name="deskripsi_menu" rows="3"
              class="form-control @error('deskripsi_menu') is-invalid @enderror" required>{{ old('deskripsi_menu', $menu->deskripsi_menu ?? '') }}</textarea>
    @error('deskripsi_menu')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="foto_menu" class="form-label">Foto menu</label>
    @if(!empty($menu->foto_menu))
        <div class="mb-2">
            <img class="form-preview" src="{{ asset('storage/' . $menu->foto_menu) }}" alt="Foto menu saat ini">
        </div>
    @endif
    <input type="file" id="foto_menu" name="foto_menu" accept="image/jpeg,image/png,image/webp"
           class="form-control @error('foto_menu') is-invalid @enderror">
    <div class="form-text">
        JPG, PNG, atau WebP, maksimal 2 MB. Foto dikecilkan dan dikompres otomatis.
        @if(!empty($menu->foto_menu)) Kosongkan jika tidak ingin mengganti foto. @endif
    </div>
    @error('foto_menu')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>