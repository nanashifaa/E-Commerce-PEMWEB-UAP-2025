<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;

class FashionProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        // Get Categories
        $catBeauty = ProductCategory::where('slug', 'beauty-skincare')->first()->id;
        $catFashion = ProductCategory::where('slug', 'fashion-wanita')->first()->id;
        $catAksesoris = ProductCategory::where('slug', 'aksesoris')->first()->id;
        $catShoes = ProductCategory::where('slug', 'tas-sepatu')->first()->id;
        $catHijab = ProductCategory::where('slug', 'hijab-style')->first()->id;

        // Note: Assuming Store ID 1 exists (from UserSeeder or manual). If not, we use 1.
        $sellerId = DB::table('stores')->first()->id ?? 1; 

        $products = [
            // FASHION
            [
                'name' => 'Blouse Kotak-Kotak Vintage',
                'slug' => 'blouse-kotak-vintage',
                'description' => 'Blouse motif kotak dengan bahan katun premium. Cocok untuk hangout.',
                'price' => 125000,
                'stock' => 50,
                'category_id' => $catFashion,
                'image' => 'products/kemeja_flannel_kotak_kotak.jpg'
            ],
            [
                'name' => 'Celana Kulot Linen Highwaist',
                'slug' => 'celana-kulot-linen',
                'description' => 'Celana kulot bahan linen rami, adem dan tidak menerawang.',
                'price' => 89000,
                'stock' => 100,
                'category_id' => $catFashion,
                'image' => 'products/celana_chino_slim_fit.jpg'
            ],
            [
                'name' => 'Outer Bomber Crop Lilac',
                'slug' => 'outer-bomber-crop',
                'description' => 'Jaket bomber model crop warna lilac kekinian.',
                'price' => 150000,
                'stock' => 25,
                'category_id' => $catFashion,
                'image' => 'products/jaket_bomber_casual.jpg'
            ],

            // SHOES
            [
                'name' => 'Sneakers White Korean Style',
                'slug' => 'sneakers-white-korean',
                'description' => 'Sepatu sneakers putih sol tebal, empuk nyaman dipakai seharian.',
                'price' => 199000,
                'stock' => 40,
                'category_id' => $catShoes,
                'image' => 'products/sepatu_sneakers_urban.jpg'
            ],

            // BEAUTY (Reusing household items as beauty tools proxies)
            [
                'name' => 'Beauty Blender Sponge Set',
                'slug' => 'beauty-blender-set',
                'description' => 'Set spons makeup lembut untuk hasil flawless.',
                'price' => 35000,
                'stock' => 200,
                'category_id' => $catBeauty,
                'image' => 'products/blender_serbaguna.jpg' // "Blender" :D
            ],
            [
                'name' => 'Mixing Bowl Masker Set',
                'slug' => 'mixing-bowl-masker',
                'description' => 'Mangkuk stainless untuk meracik masker organik.',
                'price' => 25000,
                'stock' => 150,
                'category_id' => $catBeauty,
                'image' => 'products/set_panci_stainless_steel.jpg' // "Panci" -> Bowl
            ],

            // AKSESORIS
            [
                'name' => 'Smart Bracelet Rosegold',
                'slug' => 'smart-bracelet-rosegold',
                'description' => 'Gelang pintar dengan desain elegan warna rosegold.',
                'price' => 250000,
                'stock' => 30,
                'category_id' => $catAksesoris,
                'image' => 'products/smartwatch_fit_pro.jpg'
            ],
            [
                'name' => 'Earmuff Winter Fluffy',
                'slug' => 'earmuff-winter',
                'description' => 'Penutup telinga bulu halus, lucu untuk OOTD.',
                'price' => 45000,
                'stock' => 60,
                'category_id' => $catAksesoris,
                'image' => 'products/headset_wireless_hd.jpg'
            ],

             // HIJAB
            [
                'name' => 'Pashmina Plisket Premium',
                'slug' => 'pashmina-plisket',
                'description' => 'Pashmina full plisket lidi, mudah dibentuk tanpa setrika.',
                'price' => 35000,
                'stock' => 120,
                'category_id' => $catHijab,
                'image' => 'products/kemeja_flannel_kotak_kotak.jpg' // Reusing flannel texture
            ],
             [
                'name' => 'Bergo Maryam Diamond',
                'slug' => 'bergo-maryam',
                'description' => 'Hijab instan tali bahan diamond stretch.',
                'price' => 25000,
                'stock' => 300,
                'category_id' => $catHijab,
                'image' => 'products/jaket_bomber_casual.jpg' // Reusing texture
            ],
        ];

        foreach ($products as $data) {
            // Create Product
            $productId = DB::table('products')->insertGetId([
                'store_id' => $sellerId,
                'product_category_id' => $data['category_id'], // Correct Column
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'price' => $data['price'],
                'weight' => 500, // Default weight
                'stock' => $data['stock'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Image
            DB::table('product_images')->insert([
                'product_id' => $productId,
                'image' => $data['image'],
                'is_thumbnail' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "Seeded: " . $data['name'] . "\n";
        }
    }
}
