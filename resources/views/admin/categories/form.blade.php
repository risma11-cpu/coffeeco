@extends('admin.layouts.app')

@section('title', $category->exists ? 'Ubah Kategori' : 'Tambah Kategori')

@section('content')

    @php $isEdit = $category->exists; @endphp

    <div class="admin-head">
        <h1>{{ $isEdit ? 'UBAH KATEGORI' : 'TAMBAH KATEGORI' }}</h1>
        <p>Nama kategori tampil sebagai pengelompokan menu.</p>
    </div>

    <form class="form-card" method="POST"
          action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          novalidate>
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="field {{ $errors->has('name') ? 'field--error' : '' }}">
            <label for="name">NAMA KATEGORI</label>
            <input id="name" name="name" type="text" maxlength="100"
                   value="{{ old('name', $category->name) }}" autofocus required>
            @error('name')
                <span class="field__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="field {{ $errors->has('description') ? 'field--error' : '' }}">
            <label for="description">DESKRIPSI (OPSIONAL)</label>
            <textarea id="description" name="description" maxlength="1000"
                      placeholder="Contoh: Espresso dan minuman berbasis kopi">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <span class="field__error">{{ $message }}</span>
            @else
                <span class="field__hint">Maksimal 1000 karakter.</span>
            @enderror
        </div>

        <div class="form-actions">
            <button class="btn" type="submit">Simpan</button>
            <a class="btn btn--outline" href="{{ route('admin.categories.index') }}">Batal</a>
        </div>
    </form>

@endsection