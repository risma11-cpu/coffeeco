/* =====================================================
   Navbar hamburger (layar kecil)
   Buka / tutup menu. Tidak memakai GSAP.
   ===================================================== */
(function () {
    'use strict';

    var bar = document.querySelector('[data-mbar]');
    if (!bar) return;

    var toggle = bar.querySelector('[data-mbar-toggle]');
    var menu = bar.querySelector('[data-mbar-menu]');
    if (!toggle || !menu) return;

    function setOpen(open) {
        bar.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
    }

    toggle.addEventListener('click', function () {
        setOpen(!bar.classList.contains('is-open'));
    });

    // Pilih menu: tutup panel (halaman lanjut ke bagian yang dituju)
    menu.addEventListener('click', function (e) {
        if (e.target.closest('a')) setOpen(false);
    });

    // Klik di luar bar: tutup
    document.addEventListener('click', function (e) {
        if (!bar.contains(e.target)) setOpen(false);
    });

    // Tombol Esc: tutup dan kembalikan fokus ke tombol hamburger
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && bar.classList.contains('is-open')) {
            setOpen(false);
            toggle.focus();
        }
    });

    // Layar melebar ke desktop: pastikan panel tertutup
    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) setOpen(false);
    });
})();