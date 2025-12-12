@extends('layouts.seller')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4 md:px-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Ubah Produk</h2>
                <p class="text-gray-500 mt-2">
                    Perbarui data produk:
                    <span class="font-semibold text-gray-800">"{{ $product->name }}"</span>
                </p>
            </div>

            <a href="{{ route('seller.products.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-sm font-semibold transition">
                ← Kembali ke Produk
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-gray-100/60 overflow-hidden">
            <div class="p-6 md:p-8">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seller.products.update', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- NAMA --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nama Produk *</label>
                        <input type="text" name="name" required
                               value="{{ old('name', $product->name) }}"
                               class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                    </div>

                    {{-- KATEGORI --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Kategori *</label>
                        <select name="product_category_id" required
                                class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KONDISI --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Kondisi *</label>
                        <select name="condition" required
                                class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                            <option value="new"  {{ $product->condition == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>Bekas</option>
                        </select>
                    </div>

                    {{-- HARGA --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Harga *</label>
                        <input type="number" name="price" min="0" required
                               value="{{ old('price', $product->price) }}"
                               class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                    </div>

                    {{-- STOK --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Stok *</label>
                        <input type="number" name="stock" min="0" required
                               value="{{ old('stock', $product->stock) }}"
                               class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                    </div>

                    {{-- BERAT --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Berat (gram) *</label>
                        <input type="number" name="weight" min="0" required
                               value="{{ old('weight', $product->weight) }}"
                               class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full mt-1 rounded-xl border-gray-200 bg-gray-50 px-3 py-2.5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- FOTO SAAT INI --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Foto Saat Ini</label>

                        @if($product->productImages->count())
                            <div class="flex gap-2 mt-2">
                                @foreach($product->productImages as $img)
                                    <img src="{{ asset('storage/' . $img->image) }}"
                                         class="w-20 h-20 object-cover rounded border">
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-1">Belum ada foto.</p>
                        @endif
                    </div>

                    {{-- TAMBAH FOTO --}}
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tambah Foto Baru</label>
                        <input type="file" name="image[]" multiple accept="image/*"
                               class="mt-1 block w-full text-sm">
                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ingin menambah foto
                        </p>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                class="px-6 py-2 rounded-full bg-pink-600 text-white font-semibold hover:bg-pink-700">
                            Simpan
                        </button>
                        <a href="{{ route('seller.products.index') }}"
                           class="px-6 py-2 rounded-full border border-gray-300 text-gray-700">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
