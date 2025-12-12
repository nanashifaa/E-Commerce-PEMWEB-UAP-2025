<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $srcDir = public_path('upload'); // folder kamu: public/upload
        if (!File::exists($srcDir)) return;

        $files = collect(File::files($srcDir))
            ->filter(fn ($f) => in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','webp']))
            ->values();

        if ($files->isEmpty()) return;

        $products = Product::all();
        if ($products->isEmpty()) return;

        // bagi gambar ke produk secara berurutan
        $i = 0;
        foreach ($products as $product) {
            // ambil 1 gambar per produk (bisa kamu ubah jadi 2-3 kalau mau)
            $file = $files[$i % $files->count()];
            $i++;

            $originalName = $file->getFilename();
            $safeName = Str::random(6) . '-' . str_replace(' ', '-', $originalName);

            // simpan ke storage/public/products
            $destPath = 'products/' . $safeName;
            Storage::disk('public')->put($destPath, File::get($file->getRealPath()));

            // simpan ke DB (kolom: image)
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $destPath,       // nanti ditampilkan pakai asset('storage/'.$img->image)
                'is_thumbnail' => 1,
            ]);
        }
    }
}
