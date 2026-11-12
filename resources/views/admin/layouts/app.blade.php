@php $brand = config('coffee.brand'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — {{ $brand['name'] }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-crud.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-extra.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-neo.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

    <header class="admin-bar">
        <div class="admin-bar__inner">

            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span class="login__seal">
                    <span>{{ $brand['seal_top'] }}</span>
                    <span>{{ $brand['seal_bottom'] }}</span>
                </span>
                <span>Admin</span>
            </a>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">Kategori</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">Produk</a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn--ghost" type="submit">Keluar</button>
                </form>
            </nav>

        </div>
    </header>

    @yield('strip')

    <main class="admin-main">
        @if (session('success'))
            <div class="alert alert--success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert--error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>