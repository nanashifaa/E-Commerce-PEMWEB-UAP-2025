<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'name' => 'Beauty & Skincare',
                'tagline' => 'Glow Up Everyday',
                'description' => 'Serum, toner, moisturizer, dan makeup essentials untukmu.',
                'image' => 'beauty.png',
            ],
            [
                'name' => 'Fashion Wanita',
                'tagline' => 'Trendy & Chic',
                'description' => 'Blouse, dress, rok, dan outfit kekinian lainnya.',
                'image' => 'fashion.png',
            ],
            [
                'name' => 'Aksesoris',
                'tagline' => 'Complete Your Look',
                'description' => 'Kalung, gelang, anting, dan perhiasan cantik.',
                'image' => 'accessories.png',
            ],
            [
                'name' => 'Tas & Sepatu',
                'tagline' => 'Style from Head to Toe',
                'description' => 'Koleksi tas dan sepatu heels, sneakers, dan flatshoes.',
                'image' => 'bags_shoes.png',
            ],
            [
                'name' => 'Hijab Style',
                'tagline' => 'Modest & Modern',
                'description' => 'Pashmina, segi empat, dan outfit muslimah modern.',
                'image' => 'hijab.png',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'id'   => null, // Auto increment
                'image'       => $category['image'],
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'tagline'     => $category['tagline'],
                'description' => $category['description'],
            ]);
        }
    }
}
