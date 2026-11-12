@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('content')

    <div class="admin-head admin-head--row">
        <div>
            <h1>KATEGORI</h1>
            <p>Kelompokkan menu, contoh: Kopi, Non-Kopi, Makanan.</p>
        </div>

        <a class="btn" href="{{ route('admin.categories.create') }}">+ Tambah kategori</a>
    </div>

    @if ($categories->isEmpty())

        <div class="empty">
            <p class="empty__title">BELUM ADA KATEGORI</p>
            <p class="empty__text">Tambahkan kategori pertama, misalnya "Kopi" atau "Non-Kopi", lalu isi produknya.</p>
            <a class="btn" href="{{ route('admin.categories.create') }}">+ Tambah kategori</a>
        </div>

    @else

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>SLUG</th>
                        <th>DESKRIPSI</th>
                        <th class="table__num">ISI</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="table__name">{{ $category->name }}</td>
                            <td class="table__muted">{{ $category->slug }}</td>
                            <td class="table__muted">{{ $category->description ? \Illuminate\Support\Str::limit($category->description, 60) : '—' }}</td>
                            <td class="table__num"><span class="badge">{{ $category->products_count }} produk</span></td>
                            <td>
                                <div class="table__actions">
                                    <a class="btn btn--small btn--outline" href="{{ route('admin.categories.edit', $category) }}">Ubah</a>

                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn--small btn--danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

@endsection