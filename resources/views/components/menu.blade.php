@props(['menu'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endpush

<section class="menu" id="menu">
    <div class="menu__inner">

        <div class="menu__intro">
            <div class="menu__heading">
                <p class="menu__eyebrow">{{ $menu['eyebrow'] }}</p>
                <h2 class="menu__title">
                    <span>{{ $menu['title'][0] }}</span>
                    <span>{{ $menu['title'][1] }}</span>
                </h2>
            </div>

            <div class="menu__copy">
                <p class="menu__lead">{{ $menu['intro'] }}</p>
                <p class="menu__note">{{ $menu['note'] }}</p>
            </div>
        </div>

        <div class="menu__grid">
            @foreach ($menu['products'] as $product)
                <article class="product {{ !empty($product['spotlight']) ? 'product--featured' : '' }}">

                    <div class="product__portrait">
                        <div class="product__backdrop product__backdrop--{{ $product['backdrop'] }}"></div>

                        @if (!empty($product['badge']))
                            <div class="product__badge">
                                <span>{{ $product['badge'] }}</span>
                            </div>
                        @endif

                        @if (!empty($product['photo']) || !empty($product['photo_url']))
                            {{-- Gelas full body: foto hero atau foto unggahan dari admin --}}
                            <img class="product__cup"
                                 src="{{ $product['photo_url'] ?? asset('assets/hero/' . $product['photo']) }}"
                                 alt="{{ $product['name'] }}"
                                 loading="lazy"
                                 decoding="async">
                        @elseif (!empty($product['cup']))
                            {{-- Gelas terpisah: dipakai efek terbang ke section Favorit (public/js/favorite.js) --}}
                            <img class="product__cutout"
                                 data-fly-source
                                 src="{{ asset('assets/' . $product['cup']['file']) }}"
                                 alt="{{ $product['name'] }}"
                                 width="800"
                                 height="{{ round(800 * $product['cup']['ratio']) }}"
                                 decoding="async"
                                 style="left: calc({{ $product['cup']['left'] }} * var(--m)); top: calc({{ $product['cup']['top'] }} * var(--m)); width: calc({{ $product['cup']['width'] }} * var(--m));">
                        @elseif (!empty($product['image']))
                            <div class="product__photo">
                                <img src="{{ asset('assets/' . $product['image']) }}"
                                     alt="{{ $product['name'] }}"
                                     width="1480"
                                     height="1110"
                                     loading="lazy"
                                     decoding="async"
                                     style="left: calc({{ $product['crop_left'] }} * var(--m));">
                            </div>
                        @endif
                    </div>

                    <div class="product__details">
                        <h3 class="product__name">{{ $product['name'] }}</h3>
                        <p class="product__price">{{ $product['price_label'] }}</p>

                        <p class="product__desc">{{ $product['description'] }}</p>

                        <a class="product__order"
                           href="{{ $product['whatsapp_url'] }}"
                           target="_blank"
                           rel="noopener">
                            <span>Order via WhatsApp</span>
                            <img src="{{ asset('assets/c8a96.svg') }}" alt="" width="16" height="16">
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

        <div class="menu__footnote">
            <p>{{ $menu['footnote_left'] }}</p>
            @if (!empty($menu['footnote_right']))
                <p>{{ $menu['footnote_right'] }}</p>
            @endif
        </div>

    </div>
</section>