<?php

return [

    'brand' => [
        'name'        => 'COFFEE & CO.',
        'seal_top'    => 'COFFEE',
        'seal_bottom' => '& CO.',
    ],

    'whatsapp' => [
        // Nomor format internasional tanpa + dan spasi, contoh: 6281234567890
        // Diisi lewat file .env (COFFEE_WHATSAPP). Kalau kosong, WhatsApp akan
        // membuka pilihan kontak dengan pesan yang sudah terisi.
        'number'  => env('COFFEE_WHATSAPP', ''),

        // :product akan diganti otomatis dengan nama produk
        'message' => "Halo, saya ingin memesan:\n\nProduk: :product\nJumlah: 1\n\nApakah produknya tersedia?",
    ],

    'nav' => [
        ['label' => 'Beranda',       'href' => '#beranda'],
        ['label' => 'Menu',          'href' => '#menu'],
        ['label' => 'About Us',      'href' => '#about'],
        ['label' => 'Why Choose Us', 'href' => '#why'],
        ['label' => 'Contact',       'href' => '#contact'],
    ],

    'hero' => [
        'tagline'          => 'JEDA KECIL. RASA YANG TINGGAL.',
        'invitation_title' => ':jumlah RASA, SATU RITUAL.',
        'invitation_text'  => 'Temukan pilihanmu di bawah ↓',

        // Jeda (detik) setelah satu perpindahan selesai sebelum perpindahan berikutnya
        'interval'         => 2,

        // "Lantai" tempat produk berdiri (satuan desain Figma, 1440px).
        // Produk yang turun melewati garis ini terpotong sehingga terlihat setengah.
        'floor'            => 540,

        // Biji kopi (7 biji, masing-masing bergerak halus sendiri).
        // depth = seberapa jauh bijinya bergerak (1 = normal, makin kecil makin diam).
        'beans' => [
            ['file' => 'beans/biji-1.webp', 'left' => 422.15, 'top' => 78.87,  'width' => 107.50, 'depth' => 1.0],
            ['file' => 'beans/biji-2.webp', 'left' => 447.65, 'top' => 258.37, 'width' => 139.00, 'depth' => 1.1],
            ['file' => 'beans/biji-3.webp', 'left' => 899.65, 'top' => 262.87, 'width' => 94.50,  'depth' => 0.9],
            ['file' => 'beans/biji-4.webp', 'left' => 848.15, 'top' => 68.87,  'width' => 93.50,  'depth' => 1.0],
            ['file' => 'beans/biji-5.webp', 'left' => 507.15, 'top' => 382.87, 'width' => 66.00,  'depth' => 0.7],
            ['file' => 'beans/biji-6.webp', 'left' => 351.65, 'top' => 178.87, 'width' => 33.00,  'depth' => 0.6],
            ['file' => 'beans/biji-7.webp', 'left' => 954.90, 'top' => 200.87, 'width' => 34.75,  'depth' => 0.6],
        ],

        // Urutan di sini = urutan produk masuk ke tengah, lalu ulang dari awal.
        // image = foto full body di public/assets/hero, width = lebar (satuan Figma),
        // ratio = tinggi dibagi lebar foto.
        'slides' => [
            [
                'id'          => 'cokelat',
                'background'  => 'linear-gradient(180deg, #ce7d43 0%, #b85e2c 100%)',
                'eyebrow'     => 'COKELAT · BOLD · LEMBUT',
                'title'       => ['Cokelat kaya.', 'Jeda lebih nikmat.'],
                'description' => 'Nuansa cokelat yang kaya dengan lapisan krim dan taburan di atasnya.',
                'label'       => 'Cokelat',
                'image'       => 'slide2-cokelat_gelas-utama.webp',
                'width'       => 297.92,
                'ratio'       => 1.5990,
            ],
            [
                'id'          => 'pink-cream',
                'background'  => 'linear-gradient(180deg, #e68a77 0%, #d97160 100%)',
                'eyebrow'     => 'PINK CREAM · MANIS · CERIA',
                'title'       => ['Sedikit manis.', 'Banyak cerita.'],
                'description' => 'Warna ceria, krim melimpah, dan satu alasan lagi untuk menikmati hari.',
                'label'       => 'Pink cream',
                'image'       => 'slide3-pink-cream_gelas-utama.webp',
                'width'       => 348.40,
                'ratio'       => 1.5380,
            ],
            [
                'id'          => 'karamel',
                'background'  => 'linear-gradient(180deg, #de911d 0%, #cd790b 100%)',
                'eyebrow'     => 'KARAMEL · CREAMY · HANGAT',
                'title'       => ['Karamel lembut.', 'Mood ikut hangat.'],
                'description' => 'Manis karamel dan krim lembut, untuk jeda yang terasa istimewa.',
                'label'       => 'Karamel',
                'image'       => 'slide1-karamel_gelas-utama.webp',
                'width'       => 329.91,
                'ratio'       => 1.6303,
            ],
            [
                'id'          => 'matcha',
                'background'  => 'linear-gradient(180deg, #8db847 0%, #5a8020 100%)',
                'eyebrow'     => 'MATCHA · SEGAR · LEMBUT',
                'title'       => ['Matcha segar.', 'Jeda lebih hidup.'],
                'description' => 'Matcha dingin yang segar dengan krim lembut dan taburan di atasnya.',
                'label'       => 'Matcha',
                'image'       => 'slide4-matcha_gelas-utama.webp',
                'width'       => 300,
                'ratio'       => 1.71,
            ],
        ],
    ],

    'menu' => [
        'eyebrow'        => 'MENU · ROAST & RITUAL',
        'title'          => ['SEDIKIT BERBEDA.', 'NIKMATNYA TERASA.'],
        'intro'          => 'Kopi tak perlu rumit. Cukup rasa yang jujur, racikan penuh perhatian, dan pilihan yang cocok dengan harimu.',
        'note'           => 'Pilih rasa, lalu pesan langsung via WhatsApp.',
        'footnote_left'  => ':jumlah KARAKTER. PILIH RITUALMU.',
        'footnote_right' => 'Pesan lewat WhatsApp',

        'products' => [
            [
                'name'        => 'Classic Black',
                'price'       => 25000,
                'description' => 'Espresso, nuansa dark chocolate, dan es. Tegas, segar, tanpa berlebihan.',
                'image'       => 'bbf86.png',
                'crop_left'   => -125.8,
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
            [
                'name'        => 'Caramel Flavour',
                'price'       => 32000,
                'description' => 'Espresso, susu hangat, karamel dan sentuhan kayu manis yang lembut.',
                'image'       => '3b595.png',
                'crop_left'   => -469.9,
                'backdrop'    => 'yellow',
                'badge'       => 'FAVORIT MANIS',

                // Produk unggulan: gelasnya "terbang" ke section Favorit saat di-scroll.
                // cup = foto gelas terpisah di public/assets, left/top/width = posisi di kartu (satuan kartu 298px)
                'spotlight'   => true,
                'cup'         => ['file' => 'caramel-flavour.webp', 'left' => 56.7, 'top' => 39, 'width' => 182.7, 'ratio' => 1.4775],
            ],
            [
                'name'        => 'Vanilla Flavour',
                'price'       => 32000,
                'description' => 'Espresso dan vanila dengan cold foam. Ringan, harum, dan creamy.',
                'image'       => 'e01c0.png',
                'crop_left'   => -810.3,
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
            [
                'name'        => 'Hazelnut Flavour',
                'price'       => 32000,
                'description' => 'Espresso, hazelnut dan susu lembut. Aroma kacang dengan akhir yang manis.',
                'image'       => '6c3a1.png',
                'crop_left'   => -1054.5,
                'backdrop'    => 'cream',
                'badge'       => null,
            ],

            // ----- Produk dari hero -----
            // photo = foto gelas full body di public/assets/hero (tanpa crop_left)
            [
                'name'        => 'Chocolate Cream',
                'price'       => 34000,
                'description' => 'Cokelat pekat dengan krim lembut dan taburan di atasnya. Bold, manis, dan menenangkan.',
                'photo'       => 'slide2-cokelat_gelas-utama.webp',
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
            [
                'name'        => 'Pink Cream',
                'price'       => 35000,
                'description' => 'Warna ceria dengan krim melimpah dan taburan manis. Satu alasan lagi untuk menikmati hari.',
                'photo'       => 'slide3-pink-cream_gelas-utama.webp',
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
            [
                'name'        => 'Caramel Cream',
                'price'       => 35000,
                'description' => 'Manis karamel dan krim lembut dengan taburan karamel. Hangat, creamy, dan istimewa.',
                'photo'       => 'slide1-karamel_gelas-utama.webp',
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
            [
                'name'        => 'Matcha Cream',
                'price'       => 36000,
                'description' => 'Matcha dingin yang segar dengan krim lembut dan taburan di atasnya. Ringan dan menyegarkan.',
                'photo'       => 'slide4-matcha_gelas-utama.webp',
                'backdrop'    => 'cream',
                'badge'       => null,
            ],
        ],
    ],

    // Section "Favorit" setelah menu (produk diambil dari menu yang bertanda 'spotlight' => true)
    'spotlight' => [
        'eyebrow' => 'FAVORIT MANIS · CARAMEL FLAVOUR',
        'title'   => ['KENAPA SEMUA', 'JATUH CINTA.'],
        'intro'   => 'Caramel Flavour jadi pilihan yang paling sering dicari. Manisnya pas, aromanya hangat, dan rasanya bikin ingin kembali lagi.',
        'reasons' => [
            [
                'title' => 'Manis yang pas',
                'text'  => 'Karamel dan susu hangat seimbang. Manisnya terasa, tapi tidak membuat enek.',
            ],
            [
                'title' => 'Aroma kayu manis',
                'text'  => 'Sentuhan kayu manis memberi aroma hangat yang membuat jeda terasa lebih nyaman.',
            ],
            [
                'title' => 'Espresso yang jujur',
                'text'  => 'Dasar espresso tetap terasa, jadi rasanya berlapis dan tidak sekadar manis.',
            ],
        ],
        'cta' => 'Order via WhatsApp',
    ],

];