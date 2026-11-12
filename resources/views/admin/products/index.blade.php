@extends('admin.layouts.app')

@section('title', 'Produk')

@section('content')

    @php
        $filterAktif = $filter['q'] !== '' || $filter['category'] || $filter['status'];
    @endphp

    <div class="admin-head admin-head--row">
        <div>
            <h1>PRODUK</h1>
            <p>Menu yang dijual dan tampil di website.</p>
        </div>

        <a class="btn" href="{{ route('admin.products.create') }}">+ Tambah produk</a>
    </div>

    <form class="filters" method="GET" action="{{ route('admin.products.index') }}">
        <div class="field field--grow">
            <label for="q">CARI</label>
            <input id="q" name="q" type="text" value="{{ $filter['q'] }}" placeholder="Nama produk">
        </div>

        <div class="field">
            <label for="category">KATEGORI</label>
            <select id="category" name="category">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) $filter['category'] === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="status">STATUS</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                <option value="active" {{ $filter['status'] === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $filter['status'] === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="filters__actions">
            <button class="btn btn--small" type="submit">Terapkan</button>
            @if ($filterAktif)
                <a class="btn btn--small btn--outline" href="{{ route('admin.products.index') }}">Reset</a>
            @endif
        </div>
    </form>

    @if ($products->isEmpty())

        <div class="empty">
            @if ($filterAktif)
                <p class="empty__title">TIDAK ADA YANG COCOK</p>
                <p class="empty__text">Tidak ada produk yang sesuai dengan pencarian atau filter ini.</p>
                <a class="btn btn--outline" href="{{ route('admin.products.index') }}">Reset filter</a>
            @else
                <p class="empty__title">BELUM ADA PRODUK</p>
                <p class="empty__text">Tambahkan produk pertama lengkap dengan foto, harga, dan kategorinya.</p>
                <a class="btn" href="{{ route('admin.products.create') }}">+ Tambah produk</a>
            @endif
        </div>

    @else

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <th>KATEGORI</th>
                        <th>HARGA</th>
                        <th>STATUS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <div class="cell-product">
                                    @if ($product->image_url)
                                        <img class="thumb" src="{{ $product->image_url }}" alt="">
                                    @else
                                        <span class="thumb thumb--empty">{{ strtoupper(mb_substr($product->name, 0, 1)) }}</span>
                                    @endif

                                    <div class="cell-product__text">
                                        <span class="table__name">{{ $product->name }}</span>
                                        <span class="table__muted">{{ $product->slug }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="table__muted">{{ $product->category->name }}</td>
                            <td>{{ $product->price_label }}</td>
                            <td>
                                @if ($product->status === 'active')
                                    <span class="badge">Aktif</span>
                                @else
                                    <span class="badge badge--off">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="table__actions">
                                    <a class="btn btn--small btn--outline" href="{{ route('admin.products.edit', $product) }}">Ubah</a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Hapus produk ini beserta fotonya?')">
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