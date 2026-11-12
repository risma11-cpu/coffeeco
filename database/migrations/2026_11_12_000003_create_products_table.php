<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
                $table->string('name', 150);
                $table->string('slug', 170)->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->string('image')->nullable();               // foto unggahan admin (public/uploads/products)
                $table->string('status', 10)->default('active')->index();   // active | inactive

                // Pengaturan tampilan kartu di menu website
                $table->string('badge', 40)->nullable();           // label kecil, contoh: FAVORIT MANIS
                $table->string('backdrop', 10)->default('cream');  // cream | yellow
                $table->unsignedInteger('sort_order')->default(0); // urutan tampil (kecil dulu)
                $table->text('display')->nullable();               // pengaturan foto bawaan (JSON), diisi seeder

                $table->timestamps();
            });

            return;
        }

        // Tabel sudah ada (mis. dibuat lebih dulu): tambahkan kolom yang belum ada saja
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'badge')) {
                $table->string('badge', 40)->nullable();
            }
            if (! Schema::hasColumn('products', 'backdrop')) {
                $table->string('backdrop', 10)->default('cream');
            }
            if (! Schema::hasColumn('products', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0);
            }
            if (! Schema::hasColumn('products', 'display')) {
                $table->text('display')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};