@extends('admin.layouts.app')

@section('title', $product->exists ? 'Ubah Produk' : 'Tambah Produk')

@section('content')

    @php $isEdit = $product->exists; @endphp

    <div class="admin-head">
        <h1>{{ $isEdit ? 'UBAH PRODUK' : 'TAMBAH PRODUK' }}</h1>
        <p>Isi data produk. Foto tampil di kartu menu website.</p>
    </div>

    <form class="form-card form-card--wide" method="POST" enctype="multipart/form-data"
          action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
          novalidate>
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="field {{ $errors->has('name') ? 'field--error' : '' }}">
            <label for="name">NAMA PRODUK</label>
            <input id="name" name="name" type="text" maxlength="150"
                   value="{{ old('name', $product->name) }}" autofocus required>
            @error('name')
                <span class="field__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="field {{ $errors->has('category_id') ? 'field--error' : '' }}">
                <label for="category_id">KATEGORI</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="field__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field {{ $errors->has('price') ? 'field--error' : '' }}">
                <label for="price">HARGA</label>
                <div class="input-group">
                    <span class="input-group__prefix">Rp</span>
                    <input id="price" name="price" type="number" min="0" step="1" inputmode="numeric"
                           value="{{ old('price', $product->exists ? (int) $product->price : '') }}" required>
                </div>
                @error('price')
                    <span class="field__error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="field {{ $errors->has('status') ? 'field--error' : '' }}">
            <label for="status">STATUS</label>
            <select id="status" name="status" required>
                <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Aktif (tampil di website)</option>
                <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Nonaktif (disembunyikan)</option>
            </select>
            @error('status')
                <span class="field__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="field {{ $errors->has('badge') ? 'field--error' : '' }}">
                <label for="badge">LABEL KARTU (OPSIONAL)</label>
                <input id="badge" name="badge" type="text" maxlength="40"
                       value="{{ old('badge', $product->badge) }}" placeholder="Contoh: FAVORIT MANIS">
                @error('badge')
                    <span class="field__error">{{ $message }}</span>
                @else
                    <span class="field__hint">Label kecil di pojok kartu menu. Kosongkan kalau tidak perlu.</span>
                @enderror
            </div>

            <div class="field {{ $errors->has('backdrop') ? 'field--error' : '' }}">
                <label for="backdrop">WARNA LATAR KARTU</label>
                <select id="backdrop" name="backdrop" required>
                    <option value="cream" {{ old('backdrop', $product->backdrop ?: 'cream') === 'cream' ? 'selected' : '' }}>Krem</option>
                    <option value="yellow" {{ old('backdrop', $product->backdrop) === 'yellow' ? 'selected' : '' }}>Kuning</option>
                </select>
                @error('backdrop')
                    <span class="field__error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field {{ $errors->has('sort_order') ? 'field--error' : '' }}">
                <label for="sort_order">URUTAN TAMPIL</label>
                <input id="sort_order" name="sort_order" type="number" min="0" max="9999" step="1" inputmode="numeric"
                       value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                @error('sort_order')
                    <span class="field__error">{{ $message }}</span>
                @else
                    <span class="field__hint">Angka kecil tampil lebih dulu.</span>
                @enderror
            </div>
        </div>

        <div class="field {{ $errors->has('description') ? 'field--error' : '' }}">
            <label for="description">DESKRIPSI (OPSIONAL)</label>
            <textarea id="description" name="description" maxlength="2000"
                      placeholder="Contoh: Espresso, susu hangat, karamel dan sentuhan kayu manis yang lembut.">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span class="field__error">{{ $message }}</span>
            @else
                <span class="field__hint">Maksimal 2000 karakter.</span>
            @enderror
        </div>

        <div class="field {{ $errors->has('image') ? 'field--error' : '' }}">
            <label for="image">FOTO PRODUK</label>

            <div class="upload">
                <div class="upload__preview" id="preview">
                    @if ($product->image_url)
                        <img src="{{ $product->image_url }}" alt="">
                    @else
                        Belum ada foto
                    @endif
                </div>

                <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp">
            </div>

            @error('image')
                <span class="field__error">{{ $message }}</span>
            @else
                <span class="field__hint">
                    JPG, PNG, atau WebP. Maksimal 2 MB. Pakai foto gelas dengan latar transparan (PNG / WebP) supaya tampil rapi di kartu.
                    @if ($isEdit) Kosongkan kalau tidak ingin mengganti foto. @endif
                </span>
            @enderror
        </div>

        <div class="form-actions">
            <button class="btn" type="submit">Simpan</button>
            <a class="btn btn--outline" href="{{ route('admin.products.index') }}">Batal</a>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        // Pratinjau foto sebelum disimpan
        document.getElementById('image').addEventListener('change', function (event) {
            var file = event.target.files[0];
            var box = document.getElementById('preview');

            if (!file) return;

            var reader = new FileReader();
            reader.onload = function (e) {
                box.innerHTML = '';
                var img = document.createElement('img');
                img.src = e.target.result;
                img.alt = '';
                box.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush