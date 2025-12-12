<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            'Fashion',
            'Skincare',
            'Aksesoris',
            'Kosmetik',
        ];

        foreach ($cats as $name) {
            ProductCategory::firstOrCreate(['name' => $name]);
        }
    }
}
