@extends('layouts.app')

@section('title', 'Payment Gateways')

@section('content')
<section class="max-w-4xl mx-auto px-4 pt-16 pb-24">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold">Payment Gateways</h1>
        <p class="text-gray-500">Configure your payment providers to accept payments from customers</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-700 text-sm rounded-xl px-5 py-3.5 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-700 text-sm rounded-xl px-5 py-3.5 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('dashboard.gateways.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @php
            $stripeKey = $settings['stripe']['public_key'] ?? '';
            $stripeSec = $settings['stripe']['secret_key'] ?? '';
            $stripeConfigured = !empty($stripeKey) && !empty($stripeSec);
            $paypalId = $settings['paypal']['client_id'] ?? '';
            $paypalSec = $settings['paypal']['secret'] ?? '';
            $paypalConfigured = !empty($paypalId) && !empty($paypalSec);
        @endphp

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">S</div>
                    <div>
                        <h3 class="font-bold text-lg">Stripe</h3>
                        <p class="text-xs text-gray-400">Accept credit/debit card payments</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full
                    {{ $stripeConfigured ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $stripeConfigured ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                    {{ $stripeConfigured ? 'Configured' : 'Not configured' }}
                </span>
            </div>
            <div class="p-6 grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Public Key</label>
                    <input type="text" name="stripe_public_key" value="{{ $stripeKey }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                           placeholder="pk_test_...">
                    <p class="text-xs text-gray-400 mt-1.5">Publishable key from Stripe dashboard</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Secret Key</label>
                    <input type="password" name="stripe_secret_key" value="{{ $stripeSec }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                           placeholder="sk_test_...">
                    <p class="text-xs text-gray-400 mt-1.5">Secret key from Stripe dashboard</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center text-white font-bold text-sm shadow-sm">P</div>
                    <div>
                        <h3 class="font-bold text-lg">PayPal</h3>
                        <p class="text-xs text-gray-400">Accept PayPal and Venmo payments</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full
                    {{ $paypalConfigured ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $paypalConfigured ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                    {{ $paypalConfigured ? 'Configured' : 'Not configured' }}
                </span>
            </div>
            <div class="p-6 grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Client ID</label>
                    <input type="text" name="paypal_client_id" value="{{ $paypalId }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                           placeholder="Client ID">
                    <p class="text-xs text-gray-400 mt-1.5">REST App Client ID from PayPal Developer</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Secret</label>
                    <input type="password" name="paypal_secret" value="{{ $paypalSec }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                           placeholder="Secret Key">
                    <p class="text-xs text-gray-400 mt-1.5">REST App Secret from PayPal Developer</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:shadow-orange-200 transition shadow-md inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Save Settings
            </button>
        </div>
    </form>
</section>
@endsection