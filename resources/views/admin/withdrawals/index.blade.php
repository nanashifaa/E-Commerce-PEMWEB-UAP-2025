@extends('admin.layout')

@section('title', 'Withdrawals')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Withdrawals</h1>
        <p class="text-sm text-gray-500">Manage seller withdrawal requests</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">ID</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Seller</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Amount</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Date</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($withdrawals ?? [] as $withdrawal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700">
                            #{{ $withdrawal->id }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $withdrawal->user->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-900">
                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($withdrawal->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif ($withdrawal->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Approved
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $withdrawal->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.withdrawals.show', $withdrawal->id) }}"
                               class="text-pink-600 hover:underline font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No withdrawal requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
