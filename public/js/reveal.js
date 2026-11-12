(function () {
    'use strict';

    var items = document.querySelectorAll('[data-reveal]');
    if (!items.length) return;

    // Tanpa dukungan IntersectionObserver atau bila animasi dimatikan: tampilkan langsung
    if (!('IntersectionObserver' in window) ||
        window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    document.documentElement.classList.add('reveal-on');

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;

            var el = entry.target;
            el.style.transitionDelay = (el.getAttribute('data-reveal-delay') || 0) + 'ms';
            el.classList.add('is-in');
            observer.unobserve(el);
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

    items.forEach(function (el) {
        observer.observe(el);
    });
})();