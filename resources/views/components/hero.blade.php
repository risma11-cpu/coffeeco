@props(['brand', 'nav', 'hero'])

@php
    $slides = $hero['slides'];
    $total  = count($slides);
    $floor  = $hero['floor'];
@endphp

<section class="hero" id="beranda" data-hero data-total="{{ $total }}" data-interval="{{ $hero['interval'] ?? 2 }}" aria-label="Menu unggulan {{ $brand['name'] }}">

    <div class="hero__stage" data-hero-stage style="background: {{ $slides[0]['background'] }};">

        {{-- Latar tiap produk (ditumpuk, GSAP yang mengatur tampilnya) --}}
        @foreach ($slides as $i => $slide)
            <div class="hero__bg hero__item {{ $i === 0 ? 'is-active' : '' }}"
                 data-slide="{{ $i }}"
                 data-el="bg"
                 aria-hidden="true"
                 style="background: {{ $slide['background'] }};"></div>
        @endforeach

        {{-- Nomor + penanda --}}
        <div class="hero__counter">
            <div class="hero__counts">
                @foreach ($slides as $i => $slide)
                    <p class="hero__count hero__item {{ $i === 0 ? 'is-active' : '' }}" data-slide="{{ $i }}" data-el="count" aria-hidden="true">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($total, 2, '0', STR_PAD_LEFT) }}
                    </p>
                @endforeach
            </div>

            <div class="hero__markers" aria-hidden="true">
                @foreach ($slides as $i => $slide)
                    <span class="hero__marker {{ $i === 0 ? 'is-active' : '' }}" data-marker="{{ $i }}"></span>
                @endforeach
            </div>
        </div>

        {{-- Teks pengantar produk (kiri bawah) --}}
        @foreach ($slides as $i => $slide)
            <div class="hero__intro hero__item {{ $i === 0 ? 'is-active' : '' }}" data-slide="{{ $i }}" data-el="intro">
                <p class="hero__eyebrow">{{ $slide['eyebrow'] }}</p>
                <p class="hero__title">
                    <span>{{ $slide['title'][0] }}</span>
                    <span>{{ $slide['title'][1] }}</span>
                </p>
            </div>
        @endforeach

        {{-- Tulisan besar COFFEE (diam) --}}
        <h1 class="hero__word">COFFEE</h1>

        {{-- Biji kopi + produk. Tinggi area ini = lantai tempat produk berdiri. --}}
        <div class="hero__drinks" aria-hidden="true" style="height: calc({{ $floor }} * var(--u));">

            @foreach ($hero['beans'] as $bean)
                <img class="hero__bean"
                     data-bean
                     data-depth="{{ $bean['depth'] }}"
                     src="{{ asset('assets/hero/' . $bean['file']) }}"
                     alt=""
                     decoding="async"
                     style="left: calc({{ $bean['left'] }} * var(--u)); top: calc({{ $bean['top'] }} * var(--u)); width: calc({{ $bean['width'] }} * var(--u));">
            @endforeach

            @foreach ($slides as $i => $slide)
                @php $tinggi = $slide['width'] * $slide['ratio']; @endphp
                <img class="hero__product"
                     data-product="{{ $i }}"
                     src="{{ asset('assets/hero/' . $slide['image']) }}"
                     alt=""
                     decoding="async"
                     style="left: calc({{ round(720 - $slide['width'] / 2, 2) }} * var(--u)); top: calc({{ round($floor - $tinggi, 2) }} * var(--u)); width: calc({{ $slide['width'] }} * var(--u));">
            @endforeach

        </div>

        <x-navbar :brand="$brand" :nav="$nav" />
    </div>

    {{-- Bar informasi --}}
    <div class="hero__bar">

        <div class="hero__infos">
            @foreach ($slides as $i => $slide)
                <div class="hero__info hero__item {{ $i === 0 ? 'is-active' : '' }}" data-slide="{{ $i }}" data-el="info">
                    <p class="hero__tagline">{{ $hero['tagline'] }}</p>
                    <p class="hero__desc">{{ $slide['description'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="hero__labels" aria-live="polite">
            @foreach ($slides as $i => $slide)
                <p class="hero__label hero__item {{ $i === 0 ? 'is-active' : '' }}" data-slide="{{ $i }}" data-el="label">{{ $slide['label'] }}</p>
            @endforeach
        </div>

        <div class="hero__invite">
            <p class="hero__invite-title">{{ $hero['invitation_title'] }}</p>
            <p class="hero__invite-text">{{ $hero['invitation_text'] }}</p>
        </div>

    </div>
</section>