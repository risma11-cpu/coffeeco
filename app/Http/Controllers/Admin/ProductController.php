<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $cari     = trim((string) $request->query('q', ''));
        $kategori = $request->query('category');
        $status   = $request->query('status');

        $products = Product::with('category')
            ->when($cari !== '', fn ($query) => $query->where('name', 'like', '%' . addcslashes($cari, '%_\\') . '%'))
            ->when($kategori, fn ($query) => $query->where('category_id', $kategori))
            ->when(in_array($status, ['active', 'inactive'], true), fn ($query) => $query->where('status', $status))
            ->orderBy('name')
            ->get();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(),
            'filter'     => ['q' => $cari, 'category' => $kategori, 'status' => $status],
        ]);
    }

    public function create(): View|RedirectResponse
    {
        if (Category::count() === 0) {
            return redirect()
                ->route('admin.categories.create')
                ->with('error', 'Buat kategori dulu sebelum menambah produk.');
        }

        return view('admin.products.form', [
            'product'    => new Product(['status' => 'active', 'backdrop' => 'cream', 'sort_order' => 0]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        $data['slug'] = $this->uniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->simpanFoto($request->file('image'));
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['image']);

        // Slug dibuat ulang hanya kalau namanya berubah
        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        // Foto baru menggantikan foto lama
        if ($request->hasFile('image')) {
            $this->hapusFoto($product->image);
            $data['image'] = $this->simpanFoto($request->file('image'));
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->hapusFoto($product->image);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'price'       => ['required', 'numeric', 'min:0', 'max:99999999'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
            'badge'       => ['nullable', 'string', 'max:40'],
            'backdrop'    => ['required', Rule::in(['cream', 'yellow'])],
            'sort_order'  => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.max'             => 'Nama produk maksimal 150 karakter.',
            'category_id.required' => 'Pilih kategori produk.',
            'category_id.exists'   => 'Kategori tidak ditemukan.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'price.max'            => 'Harga terlalu besar.',
            'description.max'      => 'Deskripsi maksimal 2000 karakter.',
            'status.required'      => 'Pilih status produk.',
            'status.in'            => 'Status tidak valid.',
            'badge.max'            => 'Label maksimal 40 karakter.',
            'backdrop.required'    => 'Pilih warna latar kartu.',
            'backdrop.in'          => 'Warna latar tidak valid.',
            'sort_order.integer'   => 'Urutan harus berupa angka bulat.',
            'sort_order.min'       => 'Urutan tidak boleh negatif.',
            'sort_order.max'       => 'Urutan maksimal 9999.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format foto harus JPG, PNG, atau WebP.',
            'image.max'            => 'Ukuran foto maksimal 2 MB.',
            'image.uploaded'       => 'Foto gagal diunggah. Coba file yang lebih kecil (maksimal 2 MB).',
        ]);

        // Kolom kosong diberi nilai bawaan supaya tidak ditolak database
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['badge']      = isset($data['badge']) && trim($data['badge']) !== '' ? trim($data['badge']) : null;

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i    = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /** Simpan foto ke public/uploads/products dengan nama acak, kembalikan nama filenya. */
    private function simpanFoto(UploadedFile $file): string
    {
        $folder = public_path('uploads/products');
        File::ensureDirectoryExists($folder);

        $nama = Str::uuid() . '.' . $file->extension();
        $file->move($folder, $nama);

        return $nama;
    }

    private function hapusFoto(?string $nama): void
    {
        if (! $nama) {
            return;
        }

        $path = public_path('uploads/products/' . $nama);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}