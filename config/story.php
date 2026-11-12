<?php

return [

    'about' => [
        'eyebrow'    => 'ABOUT US',
        'title'      => ['BUKAN SEKADAR', 'KOPI. INI JEDAMU.'],
        'signature'  => 'COFFEE & CO.',
        'lead'       => 'Ada cerita di antara tegukan pertama dan obrolan terakhir.',
        'paragraphs' => [
            'Coffee & Co. hadir untuk merayakan momen sederhana itu. Dari rasa kopi yang tegas sampai racikan creamy yang menyenangkan, setiap pilihan memberi ruang untuk menikmati hari dengan caramu sendiri.',
            'Tak perlu menunggu momen besar. Ambil jeda, pilih rasa favoritmu, dan biarkan percakapan mengalir.',
        ],
    ],

    'why' => [
        'eyebrow' => 'WHY CHOOSE US',
        'title'   => 'HAL KECIL, BEDANYA BESAR.',
        'reasons' => [
            [
                'icon'  => '17e99.svg',
                'title' => 'Rasa punya karakter',
                'text'  => 'Dari Classic Black yang tegas hingga sentuhan hazelnut. Ada rasa untuk setiap suasana.',
            ],
            [
                'icon'  => 'f2470.svg',
                'title' => 'Detail yang terasa',
                'text'  => 'Lapisan krim, topping, dan racikan yang saling melengkapi. Nikmat sampai tegukan terakhir.',
            ],
            [
                'icon'  => '8f775.svg',
                'title' => 'Pesan tanpa ribet',
                'text'  => 'Pilih minumanmu, sampaikan pesanan lewat WhatsApp, lalu konfirmasi bersama tim kami.',
            ],
        ],
    ],

    'contact' => [
        'eyebrow' => 'CONTACT',
        'title'   => ['JEDA BERIKUTNYA?', 'KOPI DULU.'],
        'text'    => 'Untuk pesanan, pertanyaan menu, atau sekadar menyapa. Percakapan yang baik bisa dimulai dari satu kopi.',

        // Pesan yang terisi otomatis saat tombol "Order via WhatsApp" di Contact diklik
        'message' => 'Halo Coffee & Co., saya ingin bertanya tentang menu.',

        // Nomor WhatsApp diambil dari .env (COFFEE_WHATSAPP).
        // Tulisan kecil di bawah nomor saat nomor sudah terisi:
        'whatsapp_name'        => 'Admin Coffee & Co.',
        // Tampil hanya kalau nomor belum diisi:
        'whatsapp_placeholder' => '[Nomor WhatsApp]',
        'whatsapp_note'        => 'Placeholder · belum tersedia',

        // Alamat coffee shop. Isi null untuk kembali ke placeholder.
        'address'              => 'Sigli, Pidie, Aceh',
        'address_placeholder'  => '[Alamat coffee shop]',
        'address_note'         => 'Placeholder · alamat akan dilengkapi',
    ],

    'footer' => [
        'tagline'      => 'Jeda kecil. Rasa yang tinggal.',
        'social_label' => 'IKUTI CERITA KAMI',

        // Handle mengikuti nama pada logo (COFFEE & CO.).
        // Pastikan akun dengan nama ini sudah dibuat; kalau beda, ubah handle dan url-nya.
        'social' => [
            [
                'label'  => 'Instagram',
                'handle' => '@coffeeandco',
                'url'    => 'https://www.instagram.com/coffeeandco',
            ],
            [
                'label'  => 'TikTok',
                'handle' => '@coffeeandco',
                'url'    => 'https://www.tiktok.com/@coffeeandco',
            ],
        ],
        'social_note'  => 'Placeholder · akun sosial media belum diberikan',

        'copyright'    => 'Coffee & Co. Semua hak dilindungi.',
        'legal_right'  => 'Pilihan menu: Roast & Ritual',
    ],

];