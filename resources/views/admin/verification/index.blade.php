@extends('admin.layout')

@section('content')

<div class="space-y-10">

    <h1 class="text-2xl font-bold text-gray-800">Store Verification</h1>


    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-700 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif


    {{-- PENDING STORES --}}
    <div class="bg-white shadow-sm border border-pink-200 rounded-2xl p-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Pending Stores</h2>

        @if ($pendingStores->isEmpty())
            <p class="text-gray-500 italic">No stores pending verification.</p>
        @else
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-pink-50 text-gray-600">
                    <tr>
                        <th class="py-3 px-2">Store Name</th>
                        <th class="py-3 px-2">Owner</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pendingStores as $store)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="py-3 px-2 font-medium">{{ $store->store_name }}</td>

                        <td class="py-3 px-2">{{ $store->user->name }}</td>

                        <td class="py-3 px-2">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs">
                                Pending
                            </span>
                        </td>

                        <td class="py-3 px-2 text-right space-x-3">

                            {{-- APPROVE --}}
                            <form action="{{ url('/admin/verification/approve/' . $store->id) }}" 
                                  method="POST" 
                                  class="inline approve-form">
                                @csrf
                                <button type="button" 
                                        class="text-green-600 font-medium hover:underline approve-btn">
                                    Approve
                                </button>
                            </form>

                            {{-- REJECT --}}
                            <form action="{{ url('/admin/verification/reject/' . $store->id) }}" 
                                  method="POST" 
                                  class="inline reject-form">
                                @csrf
                                <button type="button" 
                                        class="text-red-500 font-medium hover:underline reject-btn">
                                    Reject
                                </button>
                            </form>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>


    {{-- APPROVED STORES --}}
    <div class="bg-white shadow-sm border border-pink-200 rounded-2xl p-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Approved Stores</h2>

        @if ($approvedStores->isEmpty())
            <p class="text-gray-500 italic">No approved stores yet.</p>
        @else
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-pink-50 text-gray-600">
                    <tr>
                        <th class="py-3 px-2">Store Name</th>
                        <th class="py-3 px-2">Owner</th>
                        <th class="py-3 px-2">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($approvedStores as $store)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="py-3 px-2 font-medium">{{ $store->store_name }}</td>

                        <td class="py-3 px-2">{{ $store->user->name }}</td>

                        <td class="py-3 px-2">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs">
                                Approved
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</div>

@endsection


{{-- SWEETALERT --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = this.closest('form');
        Swal.fire({
            title: "Approve Store?",
            text: "This store will be approved.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#16a34a",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Approve"
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});

document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let form = this.closest('form');
        Swal.fire({
            title: "Reject Store?",
            text: "This store will be rejected and deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc2626",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Reject"
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});

</script>
@endpush
