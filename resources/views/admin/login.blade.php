@php $brand = config('coffee.brand'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk Admin — {{ $brand['name'] }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-neo.css') }}">
</head>
<body class="admin-body">

    <main class="login">
        <div class="login__card">

            <span class="login__tape">ADMIN AREA</span>

            <div class="login__brand">
                <span class="login__seal">
                    <span>{{ $brand['seal_top'] }}</span>
                    <span>{{ $brand['seal_bottom'] }}</span>
                </span>
                <span class="login__name">{{ $brand['name'] }}</span>
            </div>

            <h1 class="login__title">MASUK ADMIN</h1>
            <p class="login__sub">Kelola kategori dan menu {{ $brand['name'] }}.</p>

            <form class="login__form" method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf

                <div class="field {{ $errors->has('email') ? 'field--error' : '' }}">
                    <label for="email">EMAIL</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           autocomplete="username" autofocus required>
                    @error('email')
                        <span class="field__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field {{ $errors->has('password') ? 'field--error' : '' }}">
                    <label for="password">PASSWORD</label>
                    <input id="password" name="password" type="password"
                           autocomplete="current-password" required>
                    @error('password')
                        <span class="field__error">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn--block" type="submit">Masuk</button>
            </form>

            <a class="login__back" href="{{ route('home') }}">← Kembali ke website</a>

        </div>
    </main>

</body>
</html>