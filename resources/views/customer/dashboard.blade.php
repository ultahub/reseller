@extends('layouts.app')

@section('title', 'My Subscription')

@section('content')

<section class="max-w-4xl mx-auto px-4 pt-16 pb-24">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold">My Subscription</h1>
        <p class="text-gray-500">Welcome, {{ $user['username'] ?? $user['email'] ?? '' }}</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-100 text-red-700 text-sm rounded-xl px-5 py-3.5 flex items-center gap-2 mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if($subscription)
        @php
            $end = new DateTime($subscription['endDate']);
            $now = new DateTime();
            $remaining = max(0, (int) $now->diff($end)->format('%a'));
            $totalDays = $subscription['plan']['durationDays'] ?? 30;
            $pctUsed = $totalDays > 0 ? min(100, max(0, (($totalDays - $remaining) / $totalDays) * 100)) : 0;
        @endphp

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-8 py-6 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-sm opacity-80 mb-1">Current Plan</div>
                        <h2 class="text-2xl font-extrabold">{{ $subscription['plan']['name'] }}</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 bg-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full backdrop-blur">
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        Active
                    </span>
                </div>
            </div>
            <div class="p-8">
                <div class="grid sm:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-gray-400 text-xs uppercase font-semibold tracking-wide mb-1">Expires</div>
                        <div class="font-bold text-lg flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $end->format('M j, Y') }}
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-gray-400 text-xs uppercase font-semibold tracking-wide mb-1">Days Remaining</div>
                        <div class="font-bold text-lg flex items-center gap-2 {{ $remaining <= 7 ? 'text-red-500' : 'text-gray-900' }}">
                            <svg class="w-4 h-4 {{ $remaining <= 7 ? 'text-red-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $remaining }} days
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-gray-400 text-xs uppercase font-semibold tracking-wide mb-1">Plan Price</div>
                        <div class="font-bold text-lg flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ${{ number_format($subscription['plan']['price'], 2) }}
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="text-gray-500">Usage ({{ $remaining }} days remaining)</span>
                        <span class="font-semibold">{{ number_format($pctUsed, 0) }}% used</span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $remaining <= 7 ? 'bg-red-500' : 'bg-gradient-to-r from-orange-500 to-amber-500' }}" style="width: {{ $pctUsed }}%;"></div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 text-sm text-gray-500 pt-4 border-t border-gray-100">
                    <span class="inline-flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                        {{ $subscription['plan']['bandwidthGb'] ?? '—' }} GB bandwidth
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $subscription['plan']['deviceLimit'] ?? '—' }} devices
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $subscription['plan']['durationDays'] ?? '—' }} days
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-xl">Renew or Upgrade</h3>
                    <p class="text-gray-500 text-sm mt-1">Choose a plan to extend your subscription. The new plan will be added on top of your current expiration date.</p>
                </div>
                <a href="{{ route('customer.billing') }}" class="text-orange-500 text-sm font-semibold hover:underline whitespace-nowrap">Manage Billing &rarr;</a>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                @foreach($plans as $plan)
                    <div class="border border-gray-100 rounded-xl p-5 hover:border-orange-200 hover:shadow-md transition group">
                        <h4 class="font-bold mb-1 group-hover:text-orange-500 transition">{{ $plan['name'] }}</h4>
                        <div class="text-2xl font-extrabold mb-1">${{ number_format($plan['price'], 2) }}</div>
                        <div class="text-xs text-gray-400 mb-4">{{ $plan['durationDays'] }} days</div>
                        <a href="{{ route('customer.renew', $plan['id']) }}"
                           class="block text-center bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-lg py-2.5 text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition shadow-md">
                            Renew
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="border border-dashed border-gray-200 rounded-2xl text-center py-20">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071A10 10 0 1112 22a10 10 0 01-6.93-2.929z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <h3 class="font-bold text-lg mb-2">No Active Subscription</h3>
            <p class="text-gray-400 mb-6">You don&rsquo;t have an active subscription. Purchase one to get started.</p>
            <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition shadow-md">
                View Plans
            </a>
        </div>
    @endif
</section>

@endsection