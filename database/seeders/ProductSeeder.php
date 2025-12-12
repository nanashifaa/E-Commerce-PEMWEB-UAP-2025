<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();
        if (!$store) return;

        $cat = ProductCategory::first(); // ambil kategori pertama
        if (!$cat) return;

        $items = [
            ['name' => 'Baju Tidur Sutra', 'price' => 75000, 'stock' => 10, 'weight' => 300, 'condition' => 'new'],
            ['name' => 'Hoodie Fleece', 'price' => 120000, 'stock' => 6, 'weight' => 650, 'condition' => 'new'],
            ['name' => 'Kemeja Flanel Kotak', 'price' => 95000, 'stock' => 7, 'weight' => 450, 'condition' => 'new'],
            ['name' => 'Jas Formal Hitam', 'price' => 250000, 'stock' => 3, 'weight' => 900, 'condition' => 'new'],
            ['name' => 'Bando Korea', 'price' => 25000, 'stock' => 15, 'weight' => 120, 'condition' => 'new'],
            ['name' => 'Kalung Titanium', 'price' => 45000, 'stock' => 12, 'weight' => 80, 'condition' => 'new'],
        ];

        foreach ($items as $it) {
            Product::firstOrCreate(
                ['name' => $it['name'], 'store_id' => $store->id],
                [
                    'product_category_id' => $cat->id,
                    'slug' => Str::slug($it['name']) . '-' . rand(1000, 9999),
                    'description' => 'Produk demo seeder untuk tugas.',
                    'price' => $it['price'],
                    'stock' => $it['stock'],
                    'condition' => $it['condition'],
                    'weight' => $it['weight'],
                ]
            );
        }
    }
}
