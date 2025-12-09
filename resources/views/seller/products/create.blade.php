<x-app-layout>

<style>
    body, * { font-family: 'Poppins', sans-serif !important; }
</style>

<div class="min-h-screen bg-[#fce8f4]">

    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Add Product</h1>
    </header>

    <div class="flex">

        @include('seller.sidebar')

        <main class="flex-1 p-10">

            <div class="bg-white p-8 rounded-xl shadow border border-pink-200 max-w-3xl mx-auto">

                <h2 class="text-2xl font-semibold text-gray-800 mb-6">New Product</h2>

                {{-- VALIDATION ERRORS --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- CATEGORY --}}
                    <label class="font-medium">Category</label>
                    <select name="product_category_id" required
                            class="w-full p-3 rounded-lg border mb-4 bg-pink-50">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    {{-- NAME --}}
                    <label class="font-medium">Product Name</label>
                    <input type="text" name="name" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50">

                    {{-- PRICE --}}
                    <label class="font-medium">Price</label>
                    <input type="number" name="price" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50">

                    {{-- STOCK --}}
                    <label class="font-medium">Stock</label>
                    <input type="number" name="stock" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50">

                    {{-- WEIGHT --}}
                    <label class="font-medium">Weight (gram)</label>
                    <input type="number" name="weight" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50">

                    {{-- CONDITION --}}
                    <label class="font-medium">Condition</label>
                    <select name="condition" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50">
                        <option value="new">New</option>
                        <option value="second">Second</option>
                    </select>

                    {{-- DESCRIPTION --}}
                    <label class="font-medium">Description</label>
                    <textarea name="description" rows="4" required
                        class="w-full p-3 rounded-lg border mb-4 bg-pink-50"></textarea>

                    {{-- IMAGE --}}
                    <label class="font-medium">Product Images (optional)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full p-3 rounded-lg border mb-6 bg-pink-50">

                    <button class="w-full py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-lg">
                        Save Product
                    </button>

                </form>

            </div>

        </main>
    </div>
</div>

</x-app-layout>
