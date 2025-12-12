@extends('admin.layout')

@section('title', 'Withdrawal Detail')

@section('content')
<div class="space-y-6 max-w-3xl">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Withdrawal Detail</h1>
        <p class="text-sm text-gray-500">Review withdrawal request</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-6 space-y-4">

        <div class="flex justify-between">
            <span class="text-gray-500">Withdrawal ID</span>
            <span class="font-semibold text-gray-900">#{{ $withdrawal->id }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Seller</span>
            <span class="font-semibold text-gray-900">
                {{ $withdrawal->user->name ?? '-' }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Amount</span>
            <span class="font-semibold text-gray-900">
                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Status</span>
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
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Requested At</span>
            <span class="text-gray-700">
                {{ $withdrawal->created_at->format('d M Y H:i') }}
            </span>
        </div>
    </div>

    {{-- ACTIONS --}}
    @if ($withdrawal->status === 'pending')
        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}">
                @csrf
                <button
                    class="px-5 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700">
                    Approve
                </button>
            </form>

            <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}">
                @csrf
                <button
                    class="px-5 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700">
                    Reject
                </button>
            </form>
        </div>
    @endif

    <a href="{{ route('admin.withdrawals.index') }}"
       class="inline-block text-sm text-gray-500 hover:underline">
        ← Back to Withdrawals
    </a>

</div>
@endsection
