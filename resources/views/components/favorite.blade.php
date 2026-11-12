@props(['spotlight'])

@php
    $product = $spotlight['product'] ?? null;
    $cup     = $product['cup'] ?? null;
@endphp

@if ($product && $cup)

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/favorite.css') }}">
    @endpush

    <section class="fav" id="favorit" data-fav aria-labelledby="fav-title">
        <div class="fav__inner">

            {{-- Tempat mendarat gelas. Tanpa JavaScript, gelas ini tampil apa adanya.
                 Dengan JavaScript, gelas "terbang" dari kartu menu ke sini saat di-scroll. --}}
            <div class="fav__stage" style="--ratio: {{ $cup['ratio'] }};">
                <div class="fav__panel" aria-hidden="true"></div>

                <div class="fav__slot" data-fly-target>
                    <img class="fav__cup"
                         src="{{ asset('assets/' . $cup['file']) }}"
                         alt="{{ $product['name'] }}"
                         width="800"
                         height="{{ round(800 * $cup['ratio']) }}"
                         loading="lazy"
                         decoding="async">
                </div>
            </div>

            <div class="fav__content">
                <p class="fav__eyebrow" data-fav-copy>{{ $spotlight['eyebrow'] }}</p>

                <h2 class="fav__title" id="fav-title" data-fav-copy>
                    <span>{{ $spotlight['title'][0] }}</span>
                    <span>{{ $spotlight['title'][1] }}</span>
                </h2>

                <p class="fav__intro" data-fav-copy>{{ $spotlight['intro'] }}</p>

                <ol class="fav__reasons">
                    @foreach ($spotlight['reasons'] as $i => $reason)
                        <li class="fav__reason" data-fav-copy>
                            <span class="fav__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <h3 class="fav__reason-title">{{ $reason['title'] }}</h3>
                                <p class="fav__reason-text">{{ $reason['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <div class="fav__buy" data-fav-copy>
                    <div class="fav__buy-info">
                        <p class="fav__name">{{ $product['name'] }}</p>
                        <p class="fav__price">{{ $product['price_label'] }}</p>
                    </div>

                    <a class="fav__order"
                       href="{{ $product['whatsapp_url'] }}"
                       target="_blank"
                       rel="noopener">
                        <span>{{ $spotlight['cta'] ?? 'Order via WhatsApp' }}</span>
                        <img src="{{ asset('assets/c8a96.svg') }}" alt="" width="16" height="16">
                    </a>
                </div>
            </div>

        </div>
    </section>

@endif