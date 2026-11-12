@php $about = config('story.about'); @endphp

@once('story-assets')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/story.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/reveal.js') }}" defer></script>
    @endpush
@endonce

<section class="about" id="about">
    <div class="about__inner">

        <div class="about__story" data-reveal>
            <p class="about__eyebrow">{{ $about['eyebrow'] }}</p>

            <h2 class="about__title">
                <span>{{ $about['title'][0] }}</span>
                <span>{{ $about['title'][1] }}</span>
            </h2>

            <div class="about__signature">
                <span class="about__rule"></span>
                <span class="about__brand">{{ $about['signature'] }}</span>
            </div>
        </div>

        <div class="about__text" data-reveal data-reveal-delay="120">
            <p class="about__lead">{{ $about['lead'] }}</p>

            @foreach ($about['paragraphs'] as $paragraph)
                <p class="about__para">{{ $paragraph }}</p>
            @endforeach
        </div>

    </div>
</section>