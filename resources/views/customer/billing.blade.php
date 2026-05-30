@extends('layouts.app')

@section('title', 'Billing & Renewal')

@section('content')
<section class="max-w-4xl mx-auto px-4 pt-16 pb-24">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold">Billing</h1>
        <p class="text-gray-500">Manage your subscription and renewal options</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-100 text-red-700 text-sm rounded-xl px-5 py-3.5 flex items-center gap-2 mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm sticky top-24">
                <h3 class="font-bold text-lg mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Your Plan
                </h3>

                @if($subscription)
                    @php
                        $end = new DateTime($subscription['endDate']);
                        $now = new DateTime();
                        $remaining = max(0, (int) $now->diff($end)->format('%a'));
                    @endphp
                    <div class="space-y-5">
                        <div class="bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl p-4 text-white">
                            <div class="text-xs opacity-80 uppercase font-semibold tracking-wide">Current Plan</div>
                            <div class="text-xl font-bold mt-1">{{ $subscription['plan']['name'] }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-400 uppercase font-semibold">Expires</div>
                                <div class="font-bold text-sm mt-0.5">{{ $end->format('M j, Y') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-400 uppercase font-semibold">Status</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span class="font-bold text-sm text-green-600">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-xs text-gray-400 uppercase font-semibold mb-1">Days Remaining</div>
                            <div class="text-3xl font-extrabold {{ $remaining <= 7 ? 'text-red-500' : 'text-gray-900' }}">
                                {{ $remaining }}
                                <span class="text-sm font-medium text-gray-400">days</span>
                            </div>
                            @if($remaining <= 7)
                                <p class="text-xs text-red-500 mt-1 font-medium">Your subscription is expiring soon!</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071A10 10 0 1112 22a10 10 0 01-6.93-2.929z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-gray-500 text-sm">No active subscription found.</p>
                        <a href="{{ route('pricing') }}" class="mt-4 inline-block bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2 rounded-xl text-sm font-bold">View Plans</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                <h3 class="font-bold text-xl mb-2">Renew Subscription</h3>
                <p class="text-gray-500 text-sm mb-8">Select a plan to extend your service. Renewals are added to your current end date to prevent any loss of time.</p>

                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach($plans as $plan)
                        <div class="border border-gray-100 rounded-2xl p-6 hover:border-orange-200 hover:shadow-lg transition group">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-lg group-hover:text-orange-500 transition">{{ $plan['name'] }}</h4>
                                    <div class="text-sm text-gray-400">{{ $plan['durationDays'] }} days of access</div>
                                </div>
                                <div class="text-2xl font-extrabold">${{ number_format($plan['price'], 2) }}</div>
                            </div>

                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $plan['bandwidthGb'] ?? '—' }} GB Bandwidth</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Up to {{ $plan['deviceLimit'] ?? '—' }} Devices</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $plan['durationDays'] }} Days Duration</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Premium Support</span>
                                </div>
                            </div>

                            <a href="{{ route('customer.renew', $plan['id']) }}"
                               class="block text-center bg-gray-900 text-white rounded-xl py-3 text-sm font-bold hover:bg-orange-500 transition">
                                Renew Now
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection