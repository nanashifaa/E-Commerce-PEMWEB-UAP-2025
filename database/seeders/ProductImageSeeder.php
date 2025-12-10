<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        // Ensure directory exists
        if (!File::exists(storage_path('app/public/products'))) {
            File::makeDirectory(storage_path('app/public/products'), 0755, true);
        }

        // Correct Mapping based on database IDs
        $products = [
            1 => 'laptop_pro_15.jpg',           // Laptop Pro 15
            2 => 'smartphone_xz_max.jpg',       // Smartphone XZ Max
            3 => 'headset_wireless_hd.jpg',     // Headset Wireless HD
            4 => 'smartwatch_fit_pro.jpg',      // Smartwatch Fit Pro
            5 => 'kemeja_flannel_kotak_kotak.jpg', // Kemeja Casual Pria
            6 => 'celana_chino_slim_fit.jpg',   // Dress Elegan Wanita (Placeholder)
            7 => 'sepatu_sneakers_urban.jpg',   // Skincare Glow Set (Placeholder)
            8 => 'jaket_bomber_casual.jpg',     // Alat Fitness Dumbbell 10kg (Placeholder)
            9 => 'blender_serbaguna.jpg',       // Blender Serbaguna
            10 => 'set_panci_stainless_steel.jpg', // Set Panci Stainless Steel
        ];

        DB::table('product_images')->truncate(); 

        foreach ($products as $id => $filename) {
            DB::table('product_images')->insert([
                'product_id' => $id,
                'image' => 'products/' . $filename,
                'is_thumbnail' => 1, // FIXED COLUMN NAME
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Inserted image for Product ID: $id\n";
        }
    }
}
