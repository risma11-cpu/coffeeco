@php
    $brand  = config('coffee.brand');
    $footer = config('story.footer');

    // Catatan placeholder hanya tampil kalau masih ada akun yang belum punya tautan
    $kurangUrl = collect($footer['social'])->contains(fn ($akun) => empty($akun['url']));
@endphp

@once('contact-assets')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    @endpush
@endonce

<footer class="footer">
    <div class="footer__inner">

        <div class="footer__top">

            <div class="footer__brand">
                <div class="footer__identity">
                    <span class="footer__seal">
                        <span>{{ $brand['seal_top'] }}</span>
                        <span>{{ $brand['seal_bottom'] }}</span>
                    </span>
                    <span class="footer__name">{{ $brand['name'] }}</span>
                </div>
                <p class="footer__tagline">{{ $footer['tagline'] }}</p>
            </div>

            <div class="footer__social">
                <p class="footer__social-label">{{ $footer['social_label'] }}</p>

                <div class="footer__links">
                    @foreach ($footer['social'] as $akun)
                        @if (!empty($akun['url']))
                            <a class="footer__link" href="{{ $akun['url'] }}" target="_blank" rel="noopener">
                                <span>{{ $akun['label'] }} {{ $akun['handle'] }}</span>
                                <img src="{{ asset('assets/43b47.svg') }}" alt="" width="14" height="14">
                            </a>
                        @else
                            <span class="footer__link">
                                <span>{{ $akun['label'] }} {{ $akun['handle'] }}</span>
                                <img src="{{ asset('assets/43b47.svg') }}" alt="" width="14" height="14">
                            </span>
                        @endif
                    @endforeach
                </div>

                @if ($kurangUrl)
                    <p class="footer__note">{{ $footer['social_note'] }}</p>
                @endif
            </div>

        </div>

        <div class="footer__legal">
            <p>© {{ date('Y') }} {{ $footer['copyright'] }}</p>
            <p>{{ $footer['legal_right'] }}</p>
        </div>

    </div>
</footer>