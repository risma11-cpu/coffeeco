@props(['contact'])

@once('story-assets')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/story.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/reveal.js') }}" defer></script>
    @endpush
@endonce

@once('contact-assets')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    @endpush
@endonce

<section class="contact" id="contact">
    <div class="contact__inner">

        <div class="contact__invite" data-reveal>
            <p class="contact__eyebrow">{{ $contact['eyebrow'] }}</p>

            <h2 class="contact__title">
                <span>{{ $contact['title'][0] }}</span>
                <span>{{ $contact['title'][1] }}</span>
            </h2>

            <p class="contact__text">{{ $contact['text'] }}</p>

            <a class="contact__cta" href="{{ $contact['whatsapp_url'] }}" target="_blank" rel="noopener">
                <span>Order via WhatsApp</span>
                <img src="{{ asset('assets/d0837.svg') }}" alt="" width="16" height="16">
            </a>
        </div>

        <div class="contact__details" data-reveal data-reveal-delay="120">

            <div class="contact__item">
                <p class="contact__label">WHATSAPP</p>
                <p class="contact__value">{{ $contact['whatsapp_number'] ?? $contact['whatsapp_placeholder'] }}</p>
                <p class="contact__note">{{ $contact['whatsapp_number'] ? $contact['whatsapp_name'] : $contact['whatsapp_note'] }}</p>
            </div>

            <div class="contact__item">
                <p class="contact__label">TEMUKAN KAMI</p>
                <p class="contact__value">{{ $contact['address'] ?? $contact['address_placeholder'] }}</p>
                @unless ($contact['address'])
                    <p class="contact__note">{{ $contact['address_note'] }}</p>
                @endunless
            </div>

        </div>
    </div>
</section>