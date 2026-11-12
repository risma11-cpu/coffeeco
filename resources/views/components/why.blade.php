@php $why = config('story.why'); @endphp

@once('story-assets')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/story.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/reveal.js') }}" defer></script>
    @endpush
@endonce

<section class="why" id="why">
    <div class="why__inner">

        <div class="why__head" data-reveal>
            <p class="why__eyebrow">{{ $why['eyebrow'] }}</p>
            <h2 class="why__title">{{ $why['title'] }}</h2>
        </div>

        <div class="why__grid">
            @foreach ($why['reasons'] as $i => $reason)
                <article class="reason" data-reveal data-reveal-delay="{{ $i * 120 }}">
                    <img class="reason__icon" src="{{ asset('assets/' . $reason['icon']) }}" alt="" width="28" height="28">
                    <h3 class="reason__title">{{ $reason['title'] }}</h3>
                    <p class="reason__text">{{ $reason['text'] }}</p>
                </article>
            @endforeach
        </div>

    </div>
</section>