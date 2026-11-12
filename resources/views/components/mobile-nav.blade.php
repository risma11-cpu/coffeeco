@props(['brand', 'nav'])

@php
    $sudahMasuk = auth()->check();
    $loginUrl   = $sudahMasuk ? route('admin.dashboard') : route('login');
    $loginLabel = $sudahMasuk ? 'Dashboard' : 'Login';
@endphp

{{-- Navbar untuk layar kecil (hamburger). Tersembunyi di desktop lewat CSS (public/css/navbar.css).
     Dikendalikan oleh public/js/navbar.js (tanpa GSAP, jadi tidak terpengaruh animasi hero). --}}
<header class="mbar" data-mbar>
    <div class="mbar__row">
        <a href="#beranda" class="mbar__brand" aria-label="{{ $brand['name'] }}">
            <span class="mbar__seal">
                <span>{{ $brand['seal_top'] }}</span>
                <span>{{ $brand['seal_bottom'] }}</span>
            </span>
            <span class="mbar__name">{{ $brand['name'] }}</span>
        </a>

        <button class="mbar__toggle" type="button"
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="mbar-menu"
                data-mbar-toggle>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <nav class="mbar__menu" id="mbar-menu" aria-label="Navigasi utama" data-mbar-menu>
        <ul class="mbar__list">
            @foreach ($nav as $item)
                <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
            @endforeach
        </ul>

        <div class="mbar__actions">
            <a href="{{ $loginUrl }}" class="mbar__login">{{ $loginLabel }}</a>

            <a href="#menu" class="mbar__order">
                <span>Order Now</span>
                <img src="{{ asset('assets/c8a96.svg') }}" alt="" width="16" height="16">
            </a>
        </div>
    </nav>
</header>