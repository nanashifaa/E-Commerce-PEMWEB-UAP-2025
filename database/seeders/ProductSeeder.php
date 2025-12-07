<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil toko pertama (toko yang sudah dibuat sebelumnya)
        $store = Store::first();

        if (!$store) {
            $this->command->warn("Tidak ada store ditemukan. Jalankan StoreSeeder terlebih dahulu.");
            return;
        }

        // Ambil semua kategori
        $categories = ProductCategory::pluck('id')->toArray();

        if (empty($categories)) {
            $this->command->warn("Tidak ada kategori produk ditemukan. Jalankan ProductCategorySeeder terlebih dahulu.");
            return;
        }

        // Data contoh produk
        $products = [
            ['name' => 'Laptop Pro 15', 'price' => 15000000],
            ['name' => 'Smartphone XZ Max', 'price' => 7500000],
            ['name' => 'Headset Wireless HD', 'price' => 1200000],
            ['name' => 'Smartwatch Fit Pro', 'price' => 900000],
            ['name' => 'Kemeja Casual Pria', 'price' => 250000],
            ['name' => 'Dress Elegan Wanita', 'price' => 350000],
            ['name' => 'Skincare Glow Set', 'price' => 500000],
            ['name' => 'Alat Fitness Dumbbell 10kg', 'price' => 300000],
            ['name' => 'Blender Serbaguna', 'price' => 450000],
            ['name' => 'Set Panci Stainless Steel', 'price' => 600000],
        ];

        foreach ($products as $item) {
            Product::create([
                'store_id'              => $store->id,
                'product_category_id'   => $categories[array_rand($categories)], // kategori random
                'name'                  => $item['name'],
                'slug'                  => Str::slug($item['name']),
                'description'           => 'Deskripsi untuk produk ' . $item['name'],
                'condition'             => 'new', // new / used sesuai kebutuhan
                'price'                 => $item['price'],
                'weight'                => rand(200, 2000), // gram
                'stock'                 => rand(10, 100),
            ]);
        }
    }
}
