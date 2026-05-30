@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<section class="max-w-6xl mx-auto px-4 pt-16 pb-24">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold">Customers</h1>
            <p class="text-gray-500">{{ count($customers) }} total customers</p>
        </div>
        <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition inline-flex items-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Sale
        </a>
    </div>

    @if(count($customers) === 0)
        <div class="border border-dashed border-gray-200 rounded-2xl text-center py-20">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            <h3 class="font-bold text-lg mb-2">No Customers Yet</h3>
            <p class="text-gray-400 mb-6">Sell your first plan to get started.</p>
            <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition">
                Browse Plans
            </a>
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="p-4 border-b border-gray-100 flex items-center gap-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="customerSearch" placeholder="Search by name, email, or plan..." class="w-full border-none bg-transparent focus:outline-none text-sm">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="customerTable">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left">
                            <th class="px-5 py-3.5 font-semibold text-gray-500">User</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500">Email</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500">Plan</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500">Days Left</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($customers as $c)
                            @php
                                $sub = $c['customer']['subscriptions'][0] ?? null;
                                $remaining = $sub ? max(0, ceil((strtotime($sub['endDate']) - time()) / 86400)) : 0;
                                $status = $c['customer']['isActive']
                                    ? ($remaining <= 7 ? 'expiring' : 'active')
                                    : 'inactive';
                            @endphp
                            <tr class="hover:bg-gray-50 transition" data-status="{{ $status }}" data-search="{{ strtolower($c['customer']['username'] . ' ' . $c['customer']['email'] . ' ' . ($sub['plan']['name'] ?? '')) }}">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm text-white shadow-sm"
                                             style="background: {{ $c['customer']['isActive'] ? 'linear-gradient(135deg, #f97316, #f59e0b)' : '#e5e7eb' }};">
                                            {{ strtoupper(substr($c['customer']['username'], 0, 1)) }}
                                        </div>
                                        <span class="font-semibold">{{ $c['customer']['username'] }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-gray-500">{{ $c['customer']['email'] }}</td>
                                <td class="px-5 py-3.5">
                                    @if($sub)
                                        <span class="font-medium">{{ $sub['plan']['name'] }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($sub)
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 h-2 rounded-full bg-gray-100 overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-500"
                                                     style="width: {{ min(100, ($remaining / 30) * 100) }}%; background: {{ $remaining <= 7 ? '#ef4444' : '#22c55e' }};"></div>
                                            </div>
                                            <span class="{{ $remaining <= 7 ? 'text-red-500 font-semibold' : 'text-gray-600' }} text-xs">{{ $remaining }}d</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($c['customer']['isActive'])
                                        @if($remaining <= 7 && $remaining > 0)
                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Expiring
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Active
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</section>

<script>
document.getElementById('customerSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#customerTable tbody tr').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
});
</script>

@endsection