@extends('admin.layout')

@section('content')
    <div class="space-y-8">

        {{-- Hero section --}}
        <section class="bg-pink-50 border border-pink-100 rounded-2xl px-8 py-6 shadow-sm">
            <p class="text-sm font-medium text-pink-500">Hello, Admin 👋</p>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-1">
                Welcome back to your admin dashboard
            </h1>
            <p class="text-sm text-gray-600 mt-2 max-w-2xl">
                Here’s an overview of what’s happening in your platform today.
            </p>
        </section>

        {{-- Stats cards --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5">
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <p class="mt-3 text-3xl font-bold text-gray-900">
                    {{ $totalUsers ?? 0 }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5">
                <p class="text-sm font-medium text-gray-500">Pending Store Verification</p>
                <p class="mt-3 text-3xl font-bold text-pink-600">
                    {{ $pendingStores ?? 0 }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5">
                <p class="text-sm font-medium text-gray-500">Total Sellers</p>
                <p class="mt-3 text-3xl font-bold text-gray-900">
                    {{ $totalSellers ?? 0 }}
                </p>
            </div>

        </section>

        {{-- Placeholder: latest activity / table --}}
        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Latest Activity</h2>
                <span class="text-xs text-gray-500">Sample section (isi nanti)</span>
            </div>

            <p class="text-sm text-gray-500">
                You can add tables here for latest users, store requests, or other admin data.
            </p>
        </section>

    </div>
@endsection
