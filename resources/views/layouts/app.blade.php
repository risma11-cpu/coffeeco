<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee &amp; Co.')</title>
    <meta name="description" content="Coffee & Co. — pilih rasa favoritmu, lalu pesan langsung via WhatsApp.">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Penanda bahwa JavaScript aktif (dipakai CSS hero agar tidak berkedip sebelum animasi) --}}
    <script>document.documentElement.classList.add('js');</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    @stack('styles')
</head>
<body>

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="{{ asset('js/hero.js') }}" defer></script>
    <script src="{{ asset('js/favorite.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    @stack('scripts')
</body>
</html>