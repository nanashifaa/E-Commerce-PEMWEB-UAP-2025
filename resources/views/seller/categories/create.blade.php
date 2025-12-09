<x-app-layout>

<div class="min-h-screen bg-[#fce8f4] p-10">

    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Add Category</h2>

    <form action="{{ route('seller.categories.store') }}" method="POST">
        @csrf

        <div class="bg-white p-6 rounded-xl border shadow-sm mb-6">
            <label class="block font-medium mb-2">Category Name</label>
            <input type="text" name="name" required
                   class="w-full p-3 border rounded-xl">
        </div>

        <div class="bg-white p-6 rounded-xl border shadow-sm mb-6">
            <label class="block font-medium mb-2">Description</label>
            <textarea name="description" class="w-full p-3 border rounded-xl" rows="4"></textarea>
        </div>

        <button class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg shadow">
            Save Category
        </button>
    </form>

</div>

</x-app-layout>
