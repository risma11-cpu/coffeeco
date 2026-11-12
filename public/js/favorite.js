/* =====================================================
   Efek "gelas terbang": Caramel Flavour
   Saat menu di-scroll, gelas di kartu Caramel Flavour terlepas, ikut turun
   mengikuti scroll, lalu mendarat di sisi kiri section Favorit.
   Scroll ke atas: gelas naik lagi dan kembali ke kartu menunya.

   Pergerakan digerakkan GSAP (gsap.to untuk meredam / smoothing, gsap.set untuk posisi).
   Posisi dihitung ulang dari layout asli setiap frame, jadi tetap pas walau layar berubah ukuran.
   ===================================================== */
(function () {
    'use strict';

    var gsap = window.gsap;
    var section = document.querySelector('[data-fav]');
    var source = document.querySelector('[data-fly-source]');     // gelas di kartu menu
    var slot = section && section.querySelector('[data-fly-target]');   // tempat mendarat
    if (!gsap || !section || !source || !slot) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // ---------- Pengaturan ----------
    var START = 0.35;   // gelas mulai terbang saat puncak gelas di kartu mencapai 35% tinggi layar
    var END = 0.28;     // gelas mendarat saat puncak tempat mendarat mencapai 28% tinggi layar
    var TILT = -9;      // goyangan miring di tengah perjalanan (derajat), 0 = tanpa goyang
    var DIM = 0.35;     // kartu menu lain meredup ke nilai ini saat gelas terbang (1 = tidak meredup)
    var SMOOTH = 0.6;   // kehalusan gerak mengikuti scroll (detik), makin besar makin "mengambang"

    var root = document.documentElement;
    var card = source.closest('.product');
    var others = Array.prototype.slice.call(document.querySelectorAll('.menu .product'))
        .filter(function (el) { return el !== card; });
    var copy = Array.prototype.slice.call(section.querySelectorAll('[data-fav-copy]'));

    var flight, flyer;
    var shown = { p: 0 };   // progres yang sedang ditampilkan (0 = di kartu menu, 1 = di section Favorit)
    var ticking = false;

    function clamp(v, a, b) { return Math.min(b, Math.max(a, v)); }
    function lerp(a, b, t) { return a + (b - a) * t; }
    function ease(t) { return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2; }

    // Posisi elemen terhadap dokumen (bukan layar), supaya tidak ikut berubah saat scroll
    function rectDoc(el) {
        var r = el.getBoundingClientRect();
        return { x: r.left + window.pageXOffset, y: r.top + window.pageYOffset, w: r.width, h: r.height };
    }

    // Seberapa jauh perjalanan gelas, 0..1, berdasarkan posisi scroll sekarang
    function progressNow() {
        var a = rectDoc(source);
        var b = rectDoc(slot);
        var vh = window.innerHeight;
        var s0 = a.y - vh * START;
        var s1 = b.y - vh * END;
        var y = window.pageYOffset;
        if (s1 <= s0) return y >= s0 ? 1 : 0;
        return clamp((y - s0) / (s1 - s0), 0, 1);
    }

    function render() {
        var a = rectDoc(source);
        var b = rectDoc(slot);
        var o = rectDoc(flight);
        if (!a.w || !b.w) return;

        var p = shown.p;
        var e = ease(p);

        // titik tengah gelas di kartu (awal) dan di tempat mendarat (akhir), relatif ke wadah terbang
        var fx = a.x + a.w / 2 - o.x, fy = a.y + a.h / 2 - o.y;
        var tx = b.x + b.w / 2 - o.x, ty = b.y + b.h / 2 - o.y;

        flyer.style.width = a.w + 'px';

        gsap.set(flyer, {
            x: lerp(fx, tx, e) - a.w / 2,
            y: lerp(fy, ty, p) - a.h / 2,          // vertikal mengikuti scroll, horizontal & ukuran lebih halus
            scale: lerp(1, b.w / a.w, e),
            rotation: TILT * Math.sin(Math.PI * p),
            filter: 'drop-shadow(0px ' + (18 * e) + 'px ' + (26 * e) + 'px rgba(64,38,29,' + (0.35 * e) + '))'
        });

        // kartu menu lain meredup supaya fokus ke gelas yang terbang
        gsap.set(others, { opacity: 1 - (1 - DIM) * clamp(p / 0.12, 0, 1) });

        // teks section Favorit muncul satu per satu saat gelas mendekati tempatnya
        copy.forEach(function (el, i) {
            var q = clamp((p - (0.5 + i * 0.05)) / 0.2, 0, 1);   // elemen terakhir tepat penuh saat p = 1
            gsap.set(el, { opacity: q, y: (1 - q) * 24 });
        });
    }

    function update() {
        ticking = false;
        gsap.to(shown, { p: progressNow(), duration: SMOOTH, ease: 'power3.out', overwrite: true, onUpdate: render });
    }

    function onScroll() {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
    }

    function start() {
        root.classList.add('fav-js');   // sembunyikan gelas asli (digantikan gelas yang terbang)
        shown.p = progressNow();
        gsap.set(flyer, { transformOrigin: '50% 50%' });
        render();

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        if ('ResizeObserver' in window) {
            new ResizeObserver(onScroll).observe(document.body);   // layout bergeser (mis. gambar selesai dimuat)
        }
    }

    function setup() {
        flight = document.createElement('div');
        flight.className = 'fav-flight';
        flight.setAttribute('aria-hidden', 'true');

        flyer = new Image();
        flyer.className = 'fav-flyer';
        flyer.alt = '';
        flyer.decoding = 'async';
        flyer.src = source.currentSrc || source.src;
        flight.appendChild(flyer);
        document.body.appendChild(flight);

        // Efek hanya diaktifkan kalau fotonya benar-benar termuat.
        // Kalau gagal (file tidak ada / nama salah), tampilan biasa tetap utuh.
        function batal() {
            if (flight.parentNode) flight.parentNode.removeChild(flight);
        }

        if (flyer.decode) {
            flyer.decode().then(start, batal);
        } else {
            flyer.onload = start;
            flyer.onerror = batal;
        }
    }

    if (document.readyState === 'complete') {
        setup();
    } else {
        window.addEventListener('load', setup);
    }
})();