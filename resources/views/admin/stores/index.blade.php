@extends('admin.layout')

@section('content')

<div class="space-y-8">

    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Toko</h1>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-pink-200 shadow p-6">

        @if ($stores->count() == 0)
            <p class="text-gray-500">Tidak ada toko terdaftar.</p>
        @else

        <table class="w-full text-left text-sm">
            <thead class="border-b bg-pink-50 text-gray-600">
                <tr>
                    <th class="py-3 px-2">Nama Toko</th>
                    <th class="py-3 px-2">Pemilik</th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($stores as $store)
                <tr class="border-b hover:bg-gray-50">

                    <td class="py-3 px-2 font-medium">
                        {{ $store->store_name }}
                    </td>

                    <td class="py-3 px-2">
                        {{ $store->user->name }}
                    </td>

                    <td class="py-3 px-2">

                        {{-- STATUS BADGE --}}
                        @if ($store->is_verified == false)
                            <span class="px-3 py-1 rounded-lg text-xs bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        @elseif ($store->is_verified == true)
                            <span class="px-3 py-1 rounded-lg text-xs bg-green-100 text-green-700">
                                Approved
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-lg text-xs bg-red-100 text-red-700">
                                Rejected
                            </span>
                        @endif

                    </td>

                    <td class="py-3 px-2 space-x-2">

                        <a href="/admin/stores/{{ $store->id }}"
                           class="text-pink-600 hover:underline">
                            Detail
                        </a>

                        <a href="/admin/stores/{{ $store->id }}/edit"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

        @endif
    </div>

</div>

@endsection
