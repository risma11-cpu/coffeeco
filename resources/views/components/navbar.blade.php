@props(['brand', 'nav'])

@php
    // Tombol masuk: tamu ke halaman login, admin yang sudah masuk langsung ke dashboard
    $sudahMasuk = auth()->check();
    $loginUrl   = $sudahMasuk ? route('admin.dashboard') : route('login');
    $loginLabel = $sudahMasuk ? 'Dashboard' : 'Login';
@endphp

{{-- Navbar desktop (di atas hero). Di layar kecil diganti <x-mobile-nav> (hamburger). --}}
<header class="navbar">
    <a href="#beranda" class="navbar__brand" aria-label="{{ $brand['name'] }}">
        <span class="navbar__seal">
            <span>{{ $brand['seal_top'] }}</span>
            <span>{{ $brand['seal_bottom'] }}</span>
        </span>
        <span class="navbar__name">{{ $brand['name'] }}</span>
    </a>

    <nav class="navbar__links" aria-label="Navigasi utama">
        @foreach ($nav as $item)
            <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
        @endforeach
    </nav>

    <div class="navbar__actions">
        <a href="{{ $loginUrl }}" class="navbar__login">{{ $loginLabel }}</a>

        <a href="#menu" class="navbar__order">
            <span>Order Now</span>
            <img src="{{ asset('assets/c8a96.svg') }}" alt="" width="16" height="16">
        </a>
    </div>
</header>