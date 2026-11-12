@extends('admin.layouts.app')

@section('title', 'Dashboard')

{{-- Pita berjalan (di bawah bar atas, selebar layar) --}}
@section('strip')
    @php
        $penanda = ['COFFEE', 'ICE CREAM', 'MATCHA', 'ICED LATTE', 'CHOCOLATE', 'CARAMEL', 'STRAWBERRY', 'FRAPPE'];
    @endphp

    <div class="marquee" aria-hidden="true">
        <div class="marquee__track">
            @for ($ulang = 0; $ulang < 2; $ulang++)
                @foreach ($penanda as $teks)
                    <span class="marquee__item">{{ $teks }} <i>✦</i></span>
                @endforeach
            @endfor
        </div>
    </div>
@endsection

@section('content')

    {{-- Sambutan + barista --}}
    <section class="welcome">
        <div class="welcome__text">
            <span class="welcome__tag">{{ mb_strtoupper($tanggal) }}</span>

            <h1 class="welcome__title">
                <span>{{ mb_strtoupper($salam) }},</span>
                <span class="welcome__name">{{ mb_strtoupper($namaDepan) }}!</span>
            </h1>

            <p class="welcome__lead">
                @if ($totalProduk > 0)
                    Ada {{ $totalProduk }} produk di menu. Mau racik apa hari ini? Kopi dingin, ice cream, atau matcha?
                @else
                    Menu masih kosong. Yuk tambahkan produk pertamamu!
                @endif
            </p>

            <div class="welcome__actions">
                <a class="btn" href="{{ route('admin.products.create') }}">+ Tambah produk</a>
                <a class="btn btn--outline" href="{{ route('admin.categories.create') }}">+ Tambah kategori</a>
            </div>
        </div>

        <div class="welcome__art">
            <div class="welcome__bubble">Halo, {{ $namaDepan }}! Siap meracik hari ini?</div>
            @include('admin.partials.barista')
        </div>
    </section>

    {{-- Statistik --}}
    <section class="stats">
        <div class="stat stat--mint">
            <span class="stat__label">KATEGORI</span>
            <span class="stat__value">{{ $totalKategori }}</span>
            <span class="stat__hint">Pengelompokan menu</span>
        </div>

        <div class="stat stat--yellow">
            <span class="stat__label">PRODUK</span>
            <span class="stat__value">{{ $totalProduk }}</span>
            <span class="stat__hint">Semua produk di database</span>
        </div>

        <div class="stat stat--brown">
            <span class="stat__label">AKTIF</span>
            <span class="stat__value">{{ $produkAktif }}</span>
            <span class="stat__hint">Tampil di website</span>
        </div>

        <div class="stat stat--pink">
            <span class="stat__label">NONAKTIF</span>
            <span class="stat__value">{{ $produkNonaktif }}</span>
            <span class="stat__hint">Disembunyikan</span>
        </div>
    </section>

    {{-- Etalase produk --}}
    <section>
        <div class="section-head">
            <div>
                <h2>PRODUK KAMU</h2>
                <p>
                    @if ($dariHero)
                        Belum ada produk di database. Ini produk dari hero, tambahkan lewat menu Produk.
                    @else
                        Produk terbaru di menu website.
                    @endif
                </p>
            </div>

            <a class="btn btn--outline btn--small" href="{{ route('admin.products.index') }}">Kelola produk</a>
        </div>
    </section>

    <section class="showcase">
        @forelse ($produk as $item)
            <a class="tile tile--{{ $item['accent'] }}" href="{{ $item['url'] }}">
                <div class="tile__art">
                    @if ($dariHero)
                        <span class="tile__chip">HERO</span>
                    @elseif ($item['active'])
                        <span class="tile__chip">AKTIF</span>
                    @else
                        <span class="tile__chip tile__chip--off">NONAKTIF</span>
                    @endif

                    @if ($item['image'])
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                    @else
                        <span class="tile__letter">{{ mb_strtoupper(mb_substr($item['name'], 0, 1)) }}</span>
                    @endif
                </div>

                <div class="tile__body">
                    <span class="tile__category">{{ mb_strtoupper($item['category']) }}</span>
                    <span class="tile__name">{{ $item['name'] }}</span>
                    @if ($item['price'])
                        <span class="tile__price">{{ $item['price'] }}</span>
                    @endif
                </div>
            </a>
        @empty
            <div class="panel" style="grid-column: 1 / -1">
                Belum ada produk. Klik <strong>+ Tambah produk</strong> untuk memulai.
            </div>
        @endforelse
    </section>

    {{-- Langkah cepat + tips --}}
    <section class="dash-bottom">
        <div class="quick">
            <h3>LANGKAH CEPAT</h3>
            <div class="quick__links">
                <a class="btn" href="{{ route('admin.products.create') }}">+ Produk baru</a>
                <a class="btn btn--outline" href="{{ route('admin.categories.create') }}">+ Kategori baru</a>
                <a class="btn btn--ghost" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website</a>
            </div>
        </div>

        <div class="tips">
            <h3>TIPS BARISTA</h3>
            <p>Pakai foto PNG atau WebP transparan supaya gelas tampil menonjol di kartu menu.</p>
        </div>
    </section>

@endsection