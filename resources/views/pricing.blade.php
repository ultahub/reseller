@extends('layouts.app')

@section('title', 'Pricing')

@section('content')

<section class="max-w-6xl mx-auto px-4 pt-20 pb-24">
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
            Simple Pricing
        </div>
        <h1 class="text-4xl font-extrabold mb-3">Choose Your Plan</h1>
        <p class="text-gray-500 max-w-md mx-auto">Pick a plan for your customer. You set your own retail price on top.</p>
    </div>

    @if(count($plans) === 0)
        <div class="text-center py-20 text-gray-400">
            <div class="text-5xl mb-4">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-lg">Unable to load plans. Please try again later.</p>
        </div>
    @else
    <div x-data="{ yearly: false }">
        <div class="flex items-center justify-center gap-3 mb-10">
            <span class="text-sm font-medium" :class="!yearly ? 'text-gray-900' : 'text-gray-400'">Monthly</span>
            <button @click="yearly = !yearly"
                    class="relative w-12 h-6 rounded-full transition-colors duration-200"
                    :class="yearly ? 'bg-orange-500' : 'bg-gray-200'">
                <span class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                      :class="yearly ? 'translate-x-6' : ''"></span>
            </button>
            <span class="text-sm font-medium" :class="yearly ? 'text-gray-900' : 'text-gray-400'">
                Yearly
                <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full ml-1">Save 20%</span>
            </span>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
            @foreach($plans as $i => $plan)
                @php $isPopular = $i === 1; @endphp
                <div class="relative flex flex-col border rounded-2xl p-8 transition-all duration-300
                    {{ $isPopular ? 'border-orange-300 shadow-xl shadow-orange-100 scale-[1.02]' : 'border-gray-200 hover:shadow-xl hover:border-orange-200' }}">
                    @if($isPopular)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow-md">
                            Most Popular
                        </div>
                    @endif

                    <h3 class="text-xl font-bold mb-1">{{ $plan['name'] }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ $plan['durationDays'] }} days &middot; {{ $plan['bandwidthGb'] }} GB &middot; {{ $plan['deviceLimit'] }} device{{ $plan['deviceLimit'] > 1 ? 's' : '' }}</p>

                    <div class="mb-6">
                        <div class="text-3xl font-extrabold" x-show="!yearly">
                            ${{ number_format($plan['price'], 2) }}
                            <span class="text-base font-normal text-gray-400">/{{ $plan['durationDays'] }}d</span>
                        </div>
                        <div class="text-3xl font-extrabold" x-show="yearly" x-cloak>
                            ${{ number_format($plan['price'] * 12 * 0.8, 2) }}
                            <span class="text-base font-normal text-gray-400">/year</span>
                        </div>
                    </div>

                    <ul class="text-sm text-gray-600 space-y-3 mb-8 flex-1">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $plan['bandwidthGb'] }} GB bandwidth
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Up to {{ $plan['deviceLimit'] }} device{{ $plan['deviceLimit'] > 1 ? 's' : '' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $plan['durationDays'] }} days access
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Global servers
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            24/7 support
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Unlimited devices
                        </li>
                    </ul>

                    <a href="{{ route('checkout', $plan['id']) }}"
                       class="block text-center rounded-xl py-3 font-bold transition shadow-md
                           {{ $isPopular
                               ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white hover:shadow-lg hover:shadow-orange-200'
                               : 'bg-gray-900 text-white hover:bg-gray-800' }}">
                        Select Plan
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Money-back guarantee --}}
        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-6 py-3 rounded-full">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                30-day money-back guarantee on all plans
            </div>
        </div>
    </div>
    @endif
</section>

<style>
[x-cloak] { display: none !important; }
</style>

@endsection