(function () {
    'use strict';

    var hero = document.querySelector('[data-hero]');
    if (!hero) return;

    var gsap = window.gsap;
    var stage = hero.querySelector('[data-hero-stage]');
    var interval = parseFloat(hero.getAttribute('data-interval')) || 2;   // detik jeda antar perpindahan
    var markers = hero.querySelectorAll('[data-marker]');
    var products = Array.prototype.slice.call(hero.querySelectorAll('[data-product]'));
    var beans = Array.prototype.slice.call(hero.querySelectorAll('[data-bean]'));
    var total = products.length;
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Kalau GSAP gagal dimuat, tampilkan produk pertama apa adanya
    if (!gsap || total < 3) {
        hero.querySelectorAll('.hero__item.is-active').forEach(function (el) {
            el.style.visibility = 'visible';
            el.style.opacity = 1;
        });
        if (products[0]) products[0].style.opacity = 1;
        beans.forEach(function (b) { b.style.opacity = 1; });
        return;
    }

    // ---------- Pengaturan gerak (satuan desain Figma, lebar 1440px) ----------
    var SLOT_X = 330;       // jarak gelas samping dari tengah
    var SIDE_SCALE = 0.6;   // ukuran gelas samping dibanding gelas tengah
    var SIDE_TILT = 4;      // kemiringan gelas samping (derajat)
    var VISIBLE = 0.5;      // bagian gelas samping yang terlihat saat "turun" (0.5 = setengah)
    var MOVE = 1.3;         // lama perpindahan (detik)

    var pusat = 0;          // indeks produk yang sedang di tengah
    var sibuk = true;       // true selama animasi masuk / perpindahan
    var menunggu = false;

    // Elemen teks dan latar tiap produk
    var slides = products.map(function (_, i) {
        function cari(nama) {
            return hero.querySelector('[data-slide="' + i + '"][data-el="' + nama + '"]');
        }
        var s = {
            bg: cari('bg'),
            intro: cari('intro'),
            info: cari('info'),
            label: cari('label'),
            count: cari('count')
        };
        s.texts = [s.intro, s.info, s.label, s.count];
        return s;
    });

    function unit() {
        return stage.clientWidth / 1440;   // 1 satuan desain Figma dalam piksel
    }

    function posisiDi(i) {
        if (i === pusat) return 'center';
        if (i === (pusat + 1) % total) return 'right';
        if (i === (pusat + total - 1) % total) return 'left';
        return 'hidden';   // produk ke-4 dst: menunggu di bawah lantai sisi kanan (tidak terlihat)
    }

    // Tinggi produk tertinggi: dipakai sebagai acuan supaya gelas samping
    // yang terlihat selalu sama tinggi (rata), walau tinggi foto tiap produk beda.
    function tinggiAcuan() {
        return Math.max.apply(null, products.map(function (el) { return el.offsetHeight; }));
    }

    // Posisi akhir produk di tiap tempat (center = full body, samping = turun setengah)
    function pose(slot, tinggi, u) {
        if (slot === 'center') return { x: 0, y: 0, scale: 1, rotation: 0 };
        var arah = slot === 'left' ? -1 : 1;
        var turun = slot === 'hidden'
            ? 1.1 * SIDE_SCALE * tinggi
            : SIDE_SCALE * tinggi - VISIBLE * SIDE_SCALE * tinggiAcuan();
        return {
            x: arah * SLOT_X * u,
            y: turun,
            scale: SIDE_SCALE,
            rotation: arah * SIDE_TILT
        };
    }

    // Posisi saat produk turun habis (tidak terlihat, di bawah lantai)
    function tersembunyi(slot, tinggi, u) {
        var p = pose(slot, tinggi, u);
        p.y = 1.1 * SIDE_SCALE * tinggi;
        return p;
    }

    // Bayangan seperti bentuk produk (hanya untuk gelas di tengah)
    function bayangan(u, nyala) {
        if (!nyala) return 'drop-shadow(0px 0px 0px rgba(0,0,0,0.32))';
        return 'drop-shadow(' + (16 * u) + 'px ' + (24 * u) + 'px ' + (26 * u) + 'px rgba(0,0,0,0.32))';
    }

    // ---------- Gerak halus saat diam ----------
    function mulaiMelayang(u) {
        if (reduced) return;
        products.forEach(function (el, i) {
            var amp = (i === pusat ? 6 : 3) * u;
            gsap.to(el, { y: '-=' + amp, duration: 3.2 + i * 0.5, ease: 'sine.inOut', yoyo: true, repeat: -1, delay: i * 0.3 });
        });
    }

    function hentikanMelayang() {
        gsap.killTweensOf(products, 'y');
    }

    // Biji kopi: bergerak sangat halus dan terus-menerus, tiap biji beda ritme
    function gerakBiji(u) {
        if (reduced) return;
        beans.forEach(function (b, i) {
            var d = parseFloat(b.getAttribute('data-depth')) || 1;
            gsap.set(b, { x: -3 * d * u, y: 6 * d * u, rotation: -3 * d });
            gsap.to(b, { y: -6 * d * u, duration: 5.5 + i * 0.7, ease: 'sine.inOut', yoyo: true, repeat: -1 });
            gsap.to(b, { x: 3 * d * u, duration: 7.5 + i * 0.6, ease: 'sine.inOut', yoyo: true, repeat: -1 });
            gsap.to(b, { rotation: 3 * d, duration: 8.5 + i * 0.5, ease: 'sine.inOut', yoyo: true, repeat: -1 });
        });
    }

    function tandai(index) {
        markers.forEach(function (m, k) {
            m.classList.toggle('is-active', k === index);
        });
    }

    // ---------- Tampilan awal: semua produk naik ke tempatnya ----------
    function masukAwal() {
        var u = unit();
        var tl = gsap.timeline();
        var urutan = [pusat, (pusat + 1) % total, (pusat + total - 1) % total];

        tandai(pusat);

        products.forEach(function (el, i) {
            var p = tersembunyi(posisiDi(i), el.offsetHeight, u);
            gsap.set(el, {
                transformOrigin: '50% 100%',
                x: p.x, y: p.y, scale: p.scale, rotation: p.rotation,
                zIndex: posisiDi(i) === 'center' ? 3 : 2,
                filter: bayangan(u, false),
                autoAlpha: 0
            });
        });

        gerakBiji(u);
        tl.to(beans, { autoAlpha: 1, duration: 1.4, ease: 'power1.out', stagger: 0.1 }, 0.2);

        // Latar dan teks produk pertama
        tl.fromTo(slides[pusat].bg, { autoAlpha: 0 }, { autoAlpha: 1, duration: 0.6 }, 0);
        tl.fromTo(slides[pusat].texts,
            { y: 12 * u, autoAlpha: 0 },
            { y: 0, autoAlpha: 1, duration: reduced ? 0.2 : 0.9, ease: 'power2.out', stagger: 0.06 }, 0.5);

        // Produk naik: tengah dulu, lalu kanan, lalu kiri
        urutan.forEach(function (idx, k) {
            var el = products[idx];
            var p = pose(posisiDi(idx), el.offsetHeight, u);
            var t = 0.2 + k * 0.22;
            tl.set(el, { autoAlpha: 1 }, t);
            if (reduced) {
                tl.set(el, { x: p.x, y: p.y, scale: p.scale, rotation: p.rotation }, t);
            } else {
                tl.to(el, { x: p.x, y: p.y, scale: p.scale, rotation: p.rotation, duration: 1.5, ease: 'power3.out' }, t);
            }
        });
        if (!reduced) {
            tl.to(products[pusat], { filter: bayangan(u, true), duration: 1.2, ease: 'power2.out' }, 0.6);
        } else {
            tl.set(products[pusat], { filter: bayangan(u, true) }, 0.2);
        }

        tl.add(function () {
            sibuk = false;
            mulaiMelayang(u);
            jadwalkan();
        });
    }

    // ---------- Perpindahan: kanan -> tengah (naik), tengah -> kiri (turun), kiri -> turun lalu naik di kanan ----------
    function geser() {
        var u = unit();
        var c = pusat;
        var r = (c + 1) % total;
        var l = (c + total - 1) % total;
        var n = (c + 2) % total;   // produk yang akan naik di kanan (kalau total = 3, sama dengan l)
        var pc = products[c], pr = products[r], pl = products[l], pn = products[n];
        var sc = slides[c], sr = slides[r];
        var tl = gsap.timeline();
        var fade = reduced ? 0.2 : 1.0;

        sibuk = true;
        hentikanMelayang();
        pusat = r;
        tandai(r);

        // Latar berganti halus mengikuti warna produk yang masuk ke tengah
        gsap.set(sc.bg, { zIndex: 1 });
        gsap.set(sr.bg, { zIndex: 2 });
        tl.fromTo(sr.bg, { autoAlpha: 0 }, { autoAlpha: 1, duration: fade, ease: 'power1.inOut' }, 0);
        tl.set(sc.bg, { autoAlpha: 0, zIndex: 0 }, fade);

        // Teks berganti (tulisan COFFEE di belakang tetap diam)
        tl.to(sc.texts, { autoAlpha: 0, y: -10 * u, duration: reduced ? 0.2 : 0.45, ease: 'power2.in', stagger: 0.04 }, 0);
        tl.fromTo(sr.texts,
            { y: 12 * u, autoAlpha: 0 },
            { y: 0, autoAlpha: 1, duration: reduced ? 0.2 : 0.8, ease: 'power2.out', stagger: 0.06 }, reduced ? 0.1 : 0.5);

        // Produk
        gsap.set(pr, { zIndex: 4 });
        gsap.set(pc, { zIndex: 3 });
        gsap.set(pl, { zIndex: 2 });

        var keTengah = pose('center', pr.offsetHeight, u);
        var keKiri = pose('left', pc.offsetHeight, u);
        var hKiri = pl.offsetHeight;
        var turunKiri = tersembunyi('left', hKiri, u);
        var hKanan = pn.offsetHeight;
        var turunKanan = tersembunyi('right', hKanan, u);
        var diKanan = pose('right', hKanan, u);
        var tunggu = pn !== pl;   // true kalau ada lebih dari 3 produk

        if (reduced) {
            tl.set(pr, { x: keTengah.x, y: keTengah.y, scale: keTengah.scale, rotation: keTengah.rotation, filter: bayangan(u, true) }, 0);
            tl.set(pc, { x: keKiri.x, y: keKiri.y, scale: keKiri.scale, rotation: keKiri.rotation, filter: bayangan(u, false) }, 0);
            if (tunggu) {
                var sembunyi = tersembunyi('right', hKiri, u);
                tl.set(pl, { x: sembunyi.x, y: sembunyi.y, rotation: sembunyi.rotation, autoAlpha: 0 }, 0);
            }
            tl.set(pn, { x: diKanan.x, y: diKanan.y, scale: diKanan.scale, rotation: diKanan.rotation, autoAlpha: 1 }, 0);
        } else {
            // kanan -> tengah: naik sampai full body, bayangan muncul
            tl.to(pr, { x: keTengah.x, y: keTengah.y, scale: keTengah.scale, rotation: keTengah.rotation, duration: MOVE, ease: 'power3.inOut' }, 0);
            tl.to(pr, { filter: bayangan(u, true), duration: MOVE, ease: 'power2.inOut' }, 0.1);

            // tengah -> kiri: turun jadi setengah, bayangan hilang
            tl.to(pc, { x: keKiri.x, y: keKiri.y, scale: keKiri.scale, rotation: keKiri.rotation, duration: MOVE, ease: 'power3.inOut' }, 0);
            tl.to(pc, { filter: bayangan(u, false), duration: MOVE * 0.8, ease: 'power2.inOut' }, 0);

            // kiri -> turun habis, pindah ke kanan di bawah lantai, lalu naik setengah
            tl.to(pl, { y: turunKiri.y, duration: 0.55, ease: 'power2.in' }, 0);
            if (tunggu) {
                // lebih dari 3 produk: yang turun di kiri menunggu di bawah, produk berikutnya yang naik di kanan
                var sembunyiL = tersembunyi('right', hKiri, u);
                tl.set(pl, { x: sembunyiL.x, y: sembunyiL.y, rotation: sembunyiL.rotation, autoAlpha: 0 }, 0.6);
                tl.set(pn, { x: turunKanan.x, y: turunKanan.y, rotation: turunKanan.rotation, scale: turunKanan.scale, autoAlpha: 1 }, 0.6);
            } else {
                tl.set(pn, { x: turunKanan.x, y: turunKanan.y, rotation: turunKanan.rotation }, 0.6);
            }
            tl.to(pn, { y: diKanan.y, duration: 0.8, ease: 'power3.out' }, 0.65);
        }

        tl.add(function () {
            sibuk = false;
            mulaiMelayang(u);
            jadwalkan();
        });
    }

    function jadwalkan() {
        gsap.delayedCall(interval, function () {
            if (document.hidden) {
                menunggu = true;          // tab tidak terlihat: lanjutkan saat kembali
                return;
            }
            geser();
        });
    }

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && menunggu) {
            menunggu = false;
            geser();
        }
    });

    // Saat ukuran layar berubah, rapikan ulang posisi (kalau sedang diam)
    var tungguUkuran;
    window.addEventListener('resize', function () {
        clearTimeout(tungguUkuran);
        tungguUkuran = setTimeout(function () {
            if (sibuk) return;
            var u = unit();
            hentikanMelayang();
            products.forEach(function (el, i) {
                var p = pose(posisiDi(i), el.offsetHeight, u);
                gsap.set(el, { x: p.x, y: p.y, scale: p.scale, rotation: p.rotation });
                gsap.set(el, { filter: bayangan(u, i === pusat) });
            });
            mulaiMelayang(u);
        }, 150);
    });

    // Siapkan (decode) semua foto lebih dulu supaya gerakan tidak tersendat
    function siapkan(daftar) {
        return Promise.all(daftar.map(function (img) {
            return img && img.decode ? img.decode().catch(function () {}) : Promise.resolve();
        }));
    }

    function mulai() {
        siapkan(products.concat(beans)).then(masukAwal);
    }

    if (document.readyState === 'complete') {
        mulai();
    } else {
        window.addEventListener('load', mulai);
    }
})();