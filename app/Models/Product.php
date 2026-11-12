<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'status',
        'badge',
        'backdrop',
        'sort_order',
        'display',
    ];

    protected function casts(): array
    {
        return [
            'price'      => 'decimal:2',
            'sort_order' => 'integer',
            'display'    => 'array',   // pengaturan foto bawaan (disimpan sebagai JSON)
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Hanya produk yang berstatus aktif (tampil di website). */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /** Alamat foto produk, null kalau belum ada foto. */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->image ? asset('uploads/products/' . $this->image) : null
        );
    }

    /** Harga berformat rupiah, contoh: Rp 32.000 */
    protected function priceLabel(): Attribute
    {
        return Attribute::get(
            fn () => 'Rp ' . number_format((float) $this->price, 0, ',', '.')
        );
    }

    /**
     * Bentuk data kartu menu di website (sama persis dengan isi config/coffee.php).
     * Foto: unggahan admin dipakai kalau ada; kalau tidak, pakai foto bawaan dari 'display'.
     */
    public function toMenuItem(): array
    {
        $display = $this->display ?: [];

        $item = [
            'name'        => $this->name,
            'price'       => (float) $this->price,
            'description' => (string) $this->description,
            'backdrop'    => $this->backdrop ?: 'cream',
            'badge'       => $this->badge ?: null,
        ];

        // Produk unggulan (gelas terbang): fotonya diatur lewat 'display', unggahan admin tidak dipakai
        if (! empty($display['cup'])) {
            return $item + Arr::only($display, ['image', 'crop_left', 'cup', 'spotlight']);
        }

        if ($this->image) {
            return $item + ['photo_url' => $this->image_url];
        }

        return $item + Arr::only($display, ['image', 'crop_left', 'photo']);
    }
}