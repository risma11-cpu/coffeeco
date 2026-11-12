<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $admin    = Auth::user();
        $sekarang = now('Asia/Jakarta')->locale('id');
        $jam      = (int) $sekarang->format('G');

        $salam = match (true) {
            $jam < 11 => 'Selamat pagi',
            $jam < 15 => 'Selamat siang',
            $jam < 18 => 'Selamat sore',
            default   => 'Selamat malam',
        };

        // Produk terbaru dari menu Produk
        $products = Product::with('category')->orderByDesc('id')->take(8)->get();

        if ($products->isNotEmpty()) {
            $dariHero = false;

            $produk = $products->values()->map(fn (Product $product, int $i) => [
                'name'     => $product->name,
                'category' => $product->category?->name ?? 'Tanpa kategori',
                'price'    => $product->price_label,
                'image'    => $product->image_url,
                'active'   => $product->status === 'active',
                'url'      => route('admin.products.edit', $product),
                'accent'   => $this->accent($product->name, $i),
            ])->all();
        } else {
            // Database masih kosong: tampilkan produk dari hero (config/coffee.php)
            $dariHero = true;

            $produk = collect(config('coffee.hero.slides', []))->values()->map(fn ($slide, int $i) => [
                'name'     => $slide['label'] ?? ucfirst($slide['id'] ?? 'Produk'),
                'category' => 'Hero',
                'price'    => null,
                'image'    => isset($slide['image']) ? asset('assets/hero/' . $slide['image']) : null,
                'active'   => true,
                'url'      => route('admin.products.create'),
                'accent'   => $this->accent(($slide['id'] ?? '') . ' ' . ($slide['label'] ?? ''), $i),
            ])->all();
        }

        return view('admin.dashboard', [
            'admin'           => $admin,
            'namaDepan'       => Str::before($admin->name, ' '),
            'salam'           => $salam,
            'tanggal'         => $sekarang->translatedFormat('l, j F Y'),
            'totalKategori'   => Category::count(),
            'totalProduk'     => Product::count(),
            'produkAktif'     => Product::active()->count(),
            'produkNonaktif'  => Product::where('status', 'inactive')->count(),
            'produk'          => $produk,
            'dariHero'        => $dariHero,
        ]);
    }

    /**
     * Warna kartu produk mengikuti rasanya: matcha = mint, cokelat = coklat,
     * pink/stroberi = pink, karamel/vanilla = kuning. Selain itu bergantian.
     */
    private function accent(string $nama, int $i): string
    {
        $nama = strtolower($nama);

        return match (true) {
            str_contains($nama, 'matcha'),
            str_contains($nama, 'hijau'),
            str_contains($nama, 'green')      => 'mint',

            str_contains($nama, 'coklat'),
            str_contains($nama, 'cokelat'),
            str_contains($nama, 'chocolate'),
            str_contains($nama, 'black')      => 'brown',

            str_contains($nama, 'pink'),
            str_contains($nama, 'stroberi'),
            str_contains($nama, 'strawberry') => 'pink',

            str_contains($nama, 'karamel'),
            str_contains($nama, 'caramel'),
            str_contains($nama, 'vanilla'),
            str_contains($nama, 'orange')     => 'yellow',

            default => ['yellow', 'mint', 'pink', 'brown'][$i % 4],
        };
    }
}