@extends('layouts.app')

@section('title', 'Credits')

@section('content')

<section class="max-w-6xl mx-auto px-4 pt-16 pb-24">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold">Credits</h1>
            <p class="text-gray-500">Your credit balance and purchase history</p>
        </div>
        <a href="https://ultavpn.com/dashboard/reseller/credits" target="_blank"
           class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition inline-flex items-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buy Credits
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        {{-- Credit Card --}}
        <div class="lg:col-span-2 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl p-8 shadow-xl shadow-orange-200/40 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold uppercase tracking-widest opacity-80">Credit Balance</span>
                    <svg class="w-8 h-8 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 1.5-1.5 2-3 2s-3-.5-3-2 1.5-2 3-2 3 .5 3 2zm0 0v2m0-2V9m0 2h3m-1.5 7a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/></svg>
                </div>
                <div class="text-5xl font-extrabold mb-1">{{ number_format($credits, 1) }}</div>
                <div class="text-sm opacity-80">Credits available</div>
                <div class="mt-4 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    1 credit = 1 month of VPN access per customer
                </div>
            </div>
        </div>

        {{-- Usage Summary --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-lg mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Usage
            </h3>
            @php
                $totalCustomers = count($customers);
                $usedCredits = $totalCustomers; // rough estimate
                $maxDisplay = max($credits + $usedCredits, 10);
                $usagePct = $maxDisplay > 0 ? min(100, ($usedCredits / $maxDisplay) * 100) : 0;
            @endphp
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-1.5">
                    <span class="text-gray-500">Used</span>
                    <span class="font-semibold">{{ $usedCredits }} credits</span>
                </div>
                <div class="w-full h-2.5 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-amber-500 transition-all duration-500" style="width: {{ $usagePct }}%;"></div>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">Available</span>
                <span class="font-semibold">{{ number_format($credits, 1) }} credits</span>
            </div>
        </div>
    </div>

    {{-- Need More Credits --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-lg">Need More Credits?</h3>
                <p class="text-gray-500 text-sm mt-1">Purchase credits on the main UltaVPN reseller dashboard via any configured payment gateway.</p>
            </div>
        </div>
        <a href="https://ultavpn.com/dashboard/reseller/credits" target="_blank"
           class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition shadow-md whitespace-nowrap">
            Purchase Credits
        </a>
    </div>
</section>

@endsection