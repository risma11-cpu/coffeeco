<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Memasukkan menu awal (dari config/coffee.php) ke database.
 * Aman dijalankan berulang: produk yang sudah ada TIDAK ditimpa,
 * jadi harga / nama yang sudah kamu ubah lewat admin tetap aman.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kopi = Category::firstOrCreate(
            ['slug' => 'kopi'],
            ['name' => 'Kopi', 'description' => 'Racikan kopi dengan berbagai rasa.']
        );

        $cream = Category::firstOrCreate(
            ['slug' => 'cream'],
            ['name' => 'Cream', 'description' => 'Minuman creamy dengan krim dan taburan.']
        );

        foreach (config('coffee.menu.products') as $i => $p) {
            // Produk yang fotonya dari hero masuk kategori Cream, sisanya Kopi
            $kategori = ! empty($p['photo']) ? $cream : $kopi;

            Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $kategori->id,
                    'name'        => $p['name'],
                    'description' => $p['description'] ?? null,
                    'price'       => $p['price'],
                    'status'      => 'active',
                    'badge'       => $p['badge'] ?? null,
                    'backdrop'    => $p['backdrop'] ?? 'cream',
                    'sort_order'  => $i + 1,
                    // pengaturan foto bawaan (sprite / foto hero / gelas terbang)
                    'display'     => Arr::only($p, ['image', 'crop_left', 'photo', 'cup', 'spotlight']),
                ]
            );
        }

        $this->command->info('Menu awal siap: ' . Product::count() . ' produk di database.');
    }
}