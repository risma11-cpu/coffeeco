<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $template = (string) config('coffee.whatsapp.message');

        $menu = config('coffee.menu');

        // Menu diambil dari database (diatur lewat admin). Kalau database belum siap
        // atau masih kosong, pakai daftar bawaan di config/coffee.php.
        $menu['products'] = $this->menuProducts($menu['products']);

        $menu['products'] = array_map(function (array $product) use ($template) {
            $product['price_label']  = 'Rp ' . number_format($product['price'], 0, ',', '.');
            $product['whatsapp_url'] = $this->whatsappUrl(
                str_replace(':product', $product['name'], $template)
            );

            return $product;
        }, $menu['products']);

        // Jumlah produk dipakai di teks ("8 RASA, SATU RITUAL." dan catatan bawah menu)
        $jumlah = (string) count($menu['products']);
        $menu['footnote_left'] = str_replace(':jumlah', $jumlah, $menu['footnote_left']);

        $hero = config('coffee.hero');
        $hero['invitation_title'] = str_replace(':jumlah', $jumlah, $hero['invitation_title']);

        // Produk unggulan untuk section Favorit (yang bertanda 'spotlight' di menu)
        $spotlight = config('coffee.spotlight');
        $spotlight['product'] = null;
        foreach ($menu['products'] as $product) {
            if (!empty($product['spotlight'])) {
                $spotlight['product'] = $product;
                break;
            }
        }

        $contact = config('story.contact');
        $contact['whatsapp_url']    = $this->whatsappUrl($contact['message']);
        $contact['whatsapp_number'] = $this->whatsappDisplay();

        return view('home', [
            'brand'     => config('coffee.brand'),
            'nav'       => config('coffee.nav'),
            'hero'      => $hero,
            'menu'      => $menu,
            'spotlight' => $spotlight,
            'contact'   => $contact,
        ]);
    }

    /**
     * Daftar produk menu dari database (hanya yang aktif, urut sesuai kolom urutan).
     * Kalau database error atau tabel produk masih kosong, kembali ke daftar di config.
     */
    private function menuProducts(array $fallback): array
    {
        try {
            if (Product::count() === 0) {
                return $fallback;
            }

            return Product::active()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Product $product) => $product->toMenuItem())
                ->all();
        } catch (\Throwable $e) {
            report($e);

            return $fallback;
        }
    }

    /**
     * Nomor WhatsApp berisi angka saja. Awalan 0 diubah ke format Indonesia (62).
     */
    private function whatsappNumber(): string
    {
        $number = preg_replace('/\D+/', '', (string) config('coffee.whatsapp.number'));

        if ($number !== '' && str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    /**
     * Nomor untuk ditampilkan, contoh: +62 812-3456-7890. Null kalau belum diisi.
     */
    private function whatsappDisplay(): ?string
    {
        $number = $this->whatsappNumber();

        if ($number === '') {
            return null;
        }

        if (str_starts_with($number, '62')) {
            $local = substr($number, 2);

            return '+62 ' . preg_replace('/^(\d{3})(\d{4})(\d+)$/', '$1-$2-$3', $local);
        }

        return '+' . $number;
    }

    private function whatsappUrl(string $message): string
    {
        return 'https://wa.me/' . $this->whatsappNumber() . '?text=' . rawurlencode($message);
    }
}