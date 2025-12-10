<x-app-layout>
    <style>
        body, * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

    <div class="min-h-screen bg-[#fce8f4]">

        {{-- TOPBAR --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">Withdrawals</h1>
        </header>

        <div class="flex">

            {{-- SIDEBAR --}}
            @include('seller.sidebar')

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-10">

                <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- LEFT COLUMN: FORM --}}
                    <div class="md:col-span-1 space-y-6">
                        
                        {{-- BALANCE INFO --}}
                        <div class="bg-white border text-center p-6 rounded-xl shadow-sm">
                            <h3 class="text-gray-500 font-medium text-sm uppercase">Available Balance</h3>
                            <p class="text-3xl font-bold text-pink-600 mt-2">
                                Rp {{ number_format($balance->balance, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- WITHDRAWAL FORM --}}
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Request Withdrawal</h2>

                            <form action="{{ route('seller.withdrawals.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                                    <select name="bank_name" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" required>
                                        <option value="">Select Bank</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BNI">BNI</option>
                                        <option value="MANDIRI">Mandiri</option>
                                        <option value="BSI">BSI</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                                    <input type="number" name="account_number" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" required placeholder="e.g. 1234567890">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                                    <input type="text" name="account_name" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" required placeholder="e.g. John Doe">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Rp)</label>
                                    <input type="number" name="amount" min="10000" class="w-full border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" required placeholder="Min. 10.000">
                                </div>

                                <button type="submit" class="w-full bg-pink-600 text-white py-2 rounded-lg font-semibold hover:bg-pink-700 transition">
                                    Submit Request
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: HISTORY --}}
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm p-6 min-h-[500px]">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Withdrawal History</h2>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="text-gray-500 text-xs uppercase border-b">
                                        <tr>
                                            <th class="py-3">Date</th>
                                            <th class="py-3">Bank Details</th>
                                            <th class="py-3">Amount</th>
                                            <th class="py-3 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @forelse ($withdrawals as $w)
                                        <tr>
                                            <td class="py-3 text-sm text-gray-600">
                                                {{ $w->created_at->format('d M Y') }}
                                            </td>
                                            <td class="py-3 text-sm">
                                                <p class="font-medium text-gray-800">{{ $w->bank_name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $w->bank_account_number }} - {{ $w->bank_account_name }}</p>
                                            </td>
                                            <td class="py-3 font-semibold text-gray-800">
                                                Rp {{ number_format($w->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 text-right">
                                                @if($w->status == 'pending')
                                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                                @elseif($w->status == 'approved')
                                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Approved</span>
                                                @else
                                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-10 text-gray-400 italic">
                                                No withdrawal requests yet.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
