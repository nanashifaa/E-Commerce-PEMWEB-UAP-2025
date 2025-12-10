<x-app-layout>
    <style>
        body, * {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

    <div class="min-h-screen bg-[#fce8f4]">

        {{-- TOPBAR --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">My Balance</h1>
        </header>

        <div class="flex">

            {{-- SIDEBAR --}}
            @include('seller.sidebar')

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-10">

                <div class="max-w-4xl mx-auto space-y-6">

                    {{-- BALANCE CARD --}}
                    {{-- BALANCE CARD --}}
                    <div class="bg-white border-2 border-pink-500 rounded-2xl shadow-lg p-8 flex justify-between items-center">
                        <div>
                            <p class="text-pink-600 text-sm font-bold uppercase tracking-wider mb-1">Total Balance</p>
                            <h2 class="text-4xl font-extrabold text-gray-900">
                                Rp {{ number_format($balance->balance, 0, ',', '.') }}
                            </h2>
                        </div>
                        
                        <div>
                            <a href="/seller/withdrawals" 
                               class="bg-pink-600 text-white hover:bg-pink-700 px-6 py-3 rounded-full font-semibold shadow transition transform hover:scale-105">
                                Withdraw Funds
                            </a>
                        </div>
                    </div>

                    {{-- HISTORY SECTION --}}
                    <div class="bg-white rounded-xl shadow border border-pink-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Recent Transactions</h3>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="text-gray-500 text-xs uppercase bg-pink-50">
                                    <tr>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Reference</th>
                                        <th class="px-4 py-3">Type</th>
                                        <th class="px-4 py-3 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($histories as $history)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 text-gray-600 text-sm">
                                            {{ $history->created_at->format('d M Y H:i') }}
                                        </td>
                                        
                                        <td class="px-4 py-3 text-gray-800 font-medium text-sm">
                                            {{ $history->remarks ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            @if($history->type == 'credit')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">IN</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">OUT</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-right font-bold {{ $history->type == 'credit' ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $history->type == 'credit' ? '+' : '-' }} 
                                            Rp {{ number_format($history->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-400 italic">
                                            No transaction history found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
