@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="max-w-6xl mx-auto px-4 pt-16 pb-24">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-extrabold">Dashboard</h1>
            <p class="text-gray-500">Welcome back, {{ $user['email'] ?? 'Reseller' }}</p>
        </div>
        <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition inline-flex items-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Sale
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Credits</span>
            </div>
            <div class="text-3xl font-extrabold">{{ number_format($credits, 1) }}</div>
            <div class="text-gray-400 text-sm mt-1">Available credits</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.1-.45-2.068-1.236-2.9M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-1.1.45-2.068 1.236-2.9m7.424-2.9a4 4 0 00-3.66-2.2m0 0a4 4 0 00-3.66 2.2m7.424 0H7.424"/></svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Customers</span>
            </div>
            <div class="text-3xl font-extrabold">{{ count($customers) }}</div>
            <div class="text-gray-400 text-sm mt-1">Total customers</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Active</span>
            </div>
            <div class="text-3xl font-extrabold">{{ $activeCustomers }}</div>
            <div class="text-gray-400 text-sm mt-1">Active customers</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">Subscriptions</span>
            </div>
            <div class="text-3xl font-extrabold">{{ $withSubscriptions }}</div>
            <div class="text-gray-400 text-sm mt-1">With subscription</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8 mb-8">
        {{-- Quick Actions --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-lg mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('pricing') }}" class="border border-gray-100 rounded-xl p-4 text-center hover:bg-orange-50 hover:border-orange-200 hover:shadow-sm transition group">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-sm font-semibold">Sell a Plan</div>
                </a>
                <a href="{{ route('dashboard.customers') }}" class="border border-gray-100 rounded-xl p-4 text-center hover:bg-blue-50 hover:border-blue-200 hover:shadow-sm transition group">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    </div>
                    <div class="text-sm font-semibold">View Customers</div>
                </a>
                <a href="{{ route('dashboard.credits') }}" class="border border-gray-100 rounded-xl p-4 text-center hover:bg-emerald-50 hover:border-emerald-200 hover:shadow-sm transition group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-sm font-semibold">Buy Credits</div>
                </a>
                <a href="{{ route('dashboard.gateways') }}" class="border border-gray-100 rounded-xl p-4 text-center hover:bg-purple-50 hover:border-purple-200 hover:shadow-sm transition group">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div class="text-sm font-semibold">Payment Gateways</div>
                </a>
                <a href="https://ultavpn.com/dashboard/reseller/api" target="_blank" class="border border-gray-100 rounded-xl p-4 text-center hover:bg-gray-50 hover:border-gray-300 hover:shadow-sm transition group col-span-2">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    </div>
                    <div class="text-sm font-semibold">API Docs</div>
                </a>
            </div>
        </div>

        {{-- How It Works --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-lg mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                How Reseller Credits Work
            </h3>
            <div class="space-y-5 text-sm text-gray-600">
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 shadow-sm">1</div>
                    <div><span class="font-semibold text-gray-800">Buy credits</span> on UltaVPN at wholesale prices.</div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 shadow-sm">2</div>
                    <div><span class="font-semibold text-gray-800">Each credit</span> = 1 month of VPN access for one customer.</div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 shadow-sm">3</div>
                    <div><span class="font-semibold text-gray-800">Set your price</span> and collect payments via Stripe or PayPal on your site.</div>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 shadow-sm">4</div>
                    <div><span class="font-semibold text-gray-800">We handle delivery</span> — accounts are created automatically.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Customers --}}
    @if(count($customers) > 0)
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.1-.45-2.068-1.236-2.9M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-1.1.45-2.068 1.236-2.9"/></svg>
                    Recent Customers
                </h3>
                @if(count($customers) > 5)
                    <a href="{{ route('dashboard.customers') }}" class="text-orange-500 text-sm font-semibold hover:underline">View all &rarr;</a>
                @endif
            </div>
            <div class="divide-y divide-gray-50">
                @foreach(array_slice($customers, 0, 5) as $c)
                    @php
                        $sub = $c['customer']['subscriptions'][0] ?? null;
                        $remaining = $sub ? max(0, ceil((strtotime($sub['endDate']) - time()) / 86400)) : 0;
                    @endphp
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm text-white shadow-sm"
                                 style="background: {{ $c['customer']['isActive'] ? 'linear-gradient(135deg, #f97316, #f59e0b)' : '#e5e7eb' }};">
                                {{ strtoupper(substr($c['customer']['username'], 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $c['customer']['username'] }}</div>
                                <div class="text-xs text-gray-400">{{ $c['customer']['email'] }}</div>
                            </div>
                        </div>
                        <div class="text-right text-xs">
                            @if($sub)
                                <div class="font-semibold">{{ $sub['plan']['name'] }}</div>
                                <div class="{{ $remaining <= 7 ? 'text-red-500 font-semibold' : 'text-gray-400' }}">{{ $remaining }} days left</div>
                            @else
                                <span class="text-gray-400">No subscription</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

@endsection