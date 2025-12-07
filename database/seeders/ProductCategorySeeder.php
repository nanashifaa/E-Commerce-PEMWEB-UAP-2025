<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'tagline' => 'Peralatan elektronik modern',
                'description' => 'Produk elektronik seperti smartphone, laptop, dan gadget lainnya.',
                'image' => 'electronics.png',
            ],
            [
                'name' => 'Fashion',
                'tagline' => 'Gaya terbaru untukmu',
                'description' => 'Pakaian, aksesoris, dan kebutuhan fashion lainnya.',
                'image' => 'fashion.png',
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'tagline' => 'Produk perawatan diri terbaik',
                'description' => 'Perawatan tubuh, skincare, dan produk kesehatan.',
                'image' => 'health_beauty.png',
            ],
            [
                'name' => 'Olahraga',
                'tagline' => 'Perlengkapan olahraga lengkap',
                'description' => 'Aneka produk untuk kegiatan olahraga dan kebugaran.',
                'image' => 'sports.png',
            ],
            [
                'name' => 'Rumah Tangga',
                'tagline' => 'Kebutuhan rumah sehari-hari',
                'description' => 'Perabotan rumah, dekorasi, dan produk kebutuhan sehari-hari.',
                'image' => 'home.png',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'id'   => null, // semua kategori utama
                'image'       => $category['image'],
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'tagline'     => $category['tagline'],
                'description' => $category['description'],
            ]);
        }
    }
}
