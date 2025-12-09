<x-app-layout>

<div class="max-w-4xl mx-auto py-8">

    <h1 class="text-2xl font-bold mb-4">Topup Pending</h1>

    <table class="w-full bg-white rounded-lg shadow border">
        <thead>
            <tr class="bg-pink-100">
                <th class="p-3">User</th>
                <th class="p-3">VA / Ewallet</th>
                <th class="p-3">Nominal</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($topups as $t)
                <tr class="border-b">
                    <td class="p-3">{{ $t->user->name }}</td>
                    <td class="p-3">{{ $t->va_number }}</td>
                    <td class="p-3">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                    <td class="p-3">{{ $t->status }}</td>
                    <td class="p-3">
                        @if ($t->status === 'pending')
                        <form method="POST" action="{{ route('admin.topup.confirm', $t->id) }}">
                            @csrf
                            <button class="bg-pink-500 text-white px-4 py-1 rounded">
                                Konfirmasi
                            </button>
                        </form>
                        @else
                            <span class="text-green-600 font-bold">Sudah Masuk</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</x-app-layout>
