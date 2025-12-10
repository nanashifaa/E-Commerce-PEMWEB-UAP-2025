<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update Categories
        $categories = [
            1 => ['name' => 'Aksesories', 'slug' => 'aksesories', 'tagline' => 'Aksesoris kekinian', 'description' => 'Koleksi aksesoris lengkap'],
            2 => ['name' => 'Fashion', 'slug' => 'fashion', 'tagline' => 'Fashion pria dan wanita', 'description' => 'Koleksi fashion terbaru'], // Name same, but ensure attributes
            3 => ['name' => 'Skincare', 'slug' => 'skincare', 'tagline' => 'Perawatan wajah glowing', 'description' => 'Produk skincare terbaik'],
            4 => ['name' => 'Hijab Viscose', 'slug' => 'hijab-viscose', 'tagline' => 'Hijab nyaman dan elegan', 'description' => 'Koleksi hijab viscose premium'],
            5 => ['name' => 'Makeup', 'slug' => 'makeup', 'tagline' => 'Tampil cantik mempesona', 'description' => 'Produk makeup berkualitas'],
        ];

        foreach ($categories as $id => $data) {
            ProductCategory::updateOrCreate(['id' => $id], $data);
        }

        // 2. Populate Products
        $storeId = 1; // Assuming store ID 1 exists

        // --- AKSESORIES (ID 1) ---
        $aksesories = [
            ['name' => 'Kalung Titanium Anti Karat', 'price' => 45000, 'weight' => 50, 'description' => 'Kalung titanium awet dan tidak luntur.'],
            ['name' => 'Gelang Manik Aesthetic', 'price' => 15000, 'weight' => 20, 'description' => 'Gelang manik lucu buatan tangan.'],
            ['name' => 'Cincin Couple Silver', 'price' => 75000, 'weight' => 10, 'description' => 'Cincin couple bahan silver anti karat.'],
            ['name' => 'Bando Kepang Korea', 'price' => 25000, 'weight' => 100, 'description' => 'Bando kepang gaya korea warna pastel.'],
            ['name' => 'Jedai Hercules Kuat', 'price' => 5000, 'weight' => 50, 'description' => 'Jedai rambut bahan tebal dan kuat tidak mudah patah.'],
        ];
        $this->syncProducts(1, $storeId, $aksesories);

        // --- FASHION (ID 2) ---
        $fashion = [
            ['name' => 'Kemeja Flannel Kotak', 'price' => 125000, 'weight' => 200, 'description' => 'Kemeja flannel motif kotak-kotak bahan adem.'],
            ['name' => 'Jaz Formal Hitam', 'price' => 750000, 'weight' => 500, 'description' => 'Jaz formal pria warna hitam elegan.'],
            ['name' => 'Sweater Rajut Oversized', 'price' => 95000, 'weight' => 300, 'description' => 'Sweater rajut model oversized kekinian.'],
            ['name' => 'Hoodie Fleece Tebal', 'price' => 150000, 'weight' => 400, 'description' => 'Hoodie bahan fleece tebal dan hangat.'],
            ['name' => 'Baju Tidur Sutra', 'price' => 85000, 'weight' => 150, 'description' => 'Set baju tidur bahan sutra lembut.'],
        ];
        $this->syncProducts(2, $storeId, $fashion);

        // --- SKINCARE (ID 3) ---
        $skincare = [
            ['name' => 'Facial Wash Skintific', 'price' => 90000, 'weight' => 100, 'description' => 'Pembersih wajah Skintific ampuh angkat kotoran.'],
            ['name' => 'Moisturizer Skintific', 'price' => 150000, 'weight' => 50, 'description' => 'Pelembab wajah viral memperbaiki skin barrier.'],
            ['name' => 'Sunscreen Skintific', 'price' => 85000, 'weight' => 40, 'description' => 'Sunscreen ringan proteksi maksimal SPF 50.'],
        ];
        $this->syncProducts(3, $storeId, $skincare);

        // --- HIJAB VISCOSE (ID 4) ---
        $hijab = [
            ['name' => 'Viscose Lafiye', 'price' => 125000, 'weight' => 200, 'description' => 'Hijab viscose Lafiye kualitas premium, paling mewah.'],
            ['name' => 'Viscose Sf Giandra', 'price' => 65000, 'weight' => 200, 'description' => 'Hijab viscose Sf Giandra motif eksklusif.'],
            ['name' => 'Viscose Lozy', 'price' => 55000, 'weight' => 200, 'description' => 'Hijab viscose Lozy dengan pilihan warna cantik.'],
            ['name' => 'Viscose WMD', 'price' => 45000, 'weight' => 200, 'description' => 'Hijab viscose WMD bahan adem dan nyaman.'],
            ['name' => 'Viscose Sattka', 'price' => 40000, 'weight' => 200, 'description' => 'Hijab viscose Sattka cocok untuk sehari-hari.'],
        ];
        $this->syncProducts(4, $storeId, $hijab);

        // --- MAKEUP (ID 5) ---
        $makeup = [
            ['name' => 'Eyeshadow Palette Nude', 'price' => 85000, 'weight' => 100, 'description' => 'Palette eyeshadow warna nude pigmentasi tinggi.'],
            ['name' => 'Maskara Waterproof Volume', 'price' => 65000, 'weight' => 50, 'description' => 'Maskara anti air melentikkan bulu mata.'],
            ['name' => 'Lipstick Matte Longstay', 'price' => 55000, 'weight' => 30, 'description' => 'Lipstick matte tahan lama tidak membuat bibir kering.'],
            ['name' => 'Blush On Peach', 'price' => 45000, 'weight' => 40, 'description' => 'Perona pipi warna peach segar.'],
            ['name' => 'Pensil Alis Natural Brown', 'price' => 35000, 'weight' => 10, 'description' => 'Pensil alis warna coklat natural mudah diaplikasikan.'],
        ];
        $this->syncProducts(5, $storeId, $makeup);
    }

    private function syncProducts($categoryId, $storeId, $productsData)
    {
        // Delete existing products in this category that are NOT in the new list (Optional: keeps clean slate)
        // Product::where('product_category_id', $categoryId)->delete(); 
        
        // Instead of deleting, let's update existing or create new ones to be safe
        $existingProducts = Product::where('product_category_id', $categoryId)->orderBy('id')->get();
        
        foreach ($productsData as $index => $data) {
            $productData = array_merge($data, [
                'store_id' => $storeId,
                'product_category_id' => $categoryId,
                'slug' => Str::slug($data['name']) . '-' . rand(100, 999), 
                'condition' => 'new',
                'stock' => rand(20, 100),
            ]);

            if (isset($existingProducts[$index])) {
                // Update existing
                $existingProducts[$index]->update($productData);
            } else {
                // Create new
                Product::create($productData);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No specific down migration needed as this is a data fix
    }
};
