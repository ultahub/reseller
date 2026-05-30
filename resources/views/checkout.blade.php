@extends('layouts.app')

@section('title', 'Checkout')

@push('head')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=USD" data-namespace="paypal_sdk"></script>
@endpush

@section('content')

<section class="max-w-5xl mx-auto px-4 pt-16 pb-24">
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
            Secure Checkout
        </div>
        <h1 class="text-3xl font-extrabold">Complete Your Purchase</h1>
    </div>

    <div class="grid lg:grid-cols-5 gap-8">

        {{-- Order Summary --}}
        <div class="lg:col-span-2">
            <div class="border border-gray-200 rounded-2xl p-6 sticky top-24">
                <h3 class="font-bold text-lg mb-4">Order Summary</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center font-bold text-white text-lg shadow-md">{{ substr($plan['name'], 0, 2) }}</div>
                    <div>
                        <div class="font-semibold">{{ $plan['name'] }}</div>
                        <div class="text-sm text-gray-400">{{ $plan['durationDays'] }} days &middot; {{ $plan['bandwidthGb'] }} GB &middot; {{ $plan['deviceLimit'] }} devices</div>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-semibold">${{ number_format($plan['price'], 2) }}</span></div>
                    <div class="flex justify-between border-t border-gray-100 pt-2"><span class="font-bold text-base">Total</span><span class="font-bold text-xl">${{ number_format($plan['price'], 2) }}</span></div>
                </div>

                {{-- Trust badges --}}
                <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Secure SSL-encrypted checkout
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        30-day money-back guarantee
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Pay with confidence
                    </div>
                </div>
            </div>
        </div>

        {{-- Checkout Form --}}
        <div class="lg:col-span-3">
            <div class="border border-gray-200 rounded-2xl p-8">
                <h2 class="text-xl font-bold mb-6">Customer Details</h2>

                <div id="checkout-error" class="bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl px-4 py-3 mb-6 hidden"></div>

                <div id="checkout-success" class="hidden">
                    <div class="text-center py-6">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="font-bold text-xl text-green-700 mb-2">Subscription Active!</div>
                        <p class="text-gray-500 text-sm mb-6">Your VPN account is ready. Use these credentials to sign in to your dashboard.</p>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-left text-sm space-y-2 mb-4">
                            <div class="flex justify-between"><span class="text-gray-500">Email:</span> <span id="success-email" class="font-semibold text-gray-900"></span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Password:</span> <span id="success-password" class="font-mono bg-white border border-gray-200 px-2 py-0.5 rounded text-gray-900"></span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Plan:</span> <span id="success-plan" class="font-semibold text-gray-900"></span></div>
                        </div>
                        <p class="text-xs text-gray-400">Save your password. This is the only time it is shown.</p>
                        <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg transition">
                            Sign In to Dashboard
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <form id="checkout-form">
                    @csrf
                    <input type="hidden" name="payment_method" id="payment-method-input" value="" />

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1.5 text-gray-700">Email Address</label>
                        <input type="email" id="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition"
                               placeholder="customer@example.com" />
                        <div class="text-xs text-red-500 mt-1 hidden" id="email-error">Please enter a valid email address.</div>
                    </div>

                    {{-- Payment Method Selection --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-3 text-gray-700">Payment Method</label>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <button type="button" id="btn-stripe"
                                    class="payment-option border-2 border-gray-200 rounded-xl px-5 py-4 text-left flex items-center gap-3 hover:border-orange-300 transition"
                                    onclick="selectPayment('stripe')">
                                <svg class="w-7 h-7" viewBox="0 0 24 24"><path fill="#635BFF" d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 1.673 0 2.66.625 3.436 1.325l.073-.066.608-2.539-.043-.037C15.393 3.316 13.897 2.5 12.027 2.5c-2.876 0-4.835 1.638-4.835 4.043 0 2.519 1.94 3.507 4.633 4.477 1.897.683 3.186 1.323 3.186 2.478 0 .912-.681 1.47-1.943 1.47-1.707 0-3.086-.74-4.035-1.659l-.076.064-.621 2.603.055.049c1.105.95 2.656 1.553 4.396 1.553 3.138 0 5.274-1.672 5.274-4.415 0-2.584-2.02-3.699-4.588-4.603z"/><path fill="#635BFF" d="M8.618 14.624H6.473V7.442H8.64v7.182h-.022zm-.91-8.558a1.136 1.136 0 110-2.272 1.136 1.136 0 010 2.272zm8.346 3.36c.884 0 1.634.248 2.253.728l2.007-2.007-.041-.032c-.604-.396-1.418-.716-2.286-.716-2.029 0-3.582 1.547-3.582 3.517 0 .988.402 1.858 1.032 2.475l.002-.002c.585.568 1.382.887 2.275.887.815 0 1.546-.26 2.084-.726l-1.785-1.785-.025.02c-.33.194-.688.286-1.09.286-.617 0-1.128-.248-1.432-.628l-.008-.008c-.23-.282-.37-.672-.37-1.118 0-.991.666-1.911 1.616-1.911z"/></svg>
                                <div><div class="font-semibold text-sm">Credit Card</div><div class="text-xs text-gray-400">Pay with Stripe</div></div>
                            </button>
                            <button type="button" id="btn-paypal"
                                    class="payment-option border-2 border-gray-200 rounded-xl px-5 py-4 text-left flex items-center gap-3 hover:border-orange-300 transition"
                                    onclick="selectPayment('paypal')">
                                <svg class="w-7 h-7" viewBox="0 0 24 24"><path fill="#003087" d="M7.076 21.337H2.47a.641.641 0 01-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106z"/><path fill="#009cde" d="M19.003 6.534c-.023.143-.048.288-.077.437-.983 5.05-4.35 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106H2.47l1.16-7.35.677-4.28.214-1.357c.082-.518.53-.9 1.054-.9h3.074c1.742 0 3.344.215 4.502.838 1.152.62 1.957 1.66 2.338 3.065.718-1.08 1.767-2.963 2.066-4.584.117-.64.147-1.155.147-1.57z"/></svg>
                                <div><div class="font-semibold text-sm">PayPal</div><div class="text-xs text-gray-400">Pay with PayPal</div></div>
                            </button>
                        </div>
                    </div>

                    {{-- Stripe Card Element --}}
                    <div id="stripe-payment" class="hidden mb-6">
                        <label class="block text-sm font-semibold mb-2 text-gray-700">Card Details</label>
                        <div id="stripe-card-element" class="border border-gray-200 rounded-xl px-4 py-3"></div>
                        <div id="stripe-card-errors" class="text-red-500 text-xs mt-1"></div>
                    </div>

                    {{-- PayPal Button Container --}}
                    <div id="paypal-button-container" class="hidden mb-6"></div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-orange-200 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Pay ${{ number_format($plan['price'], 2) }}
                    </button>
                </form>

                <div id="processing-overlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
                    <div class="bg-white rounded-2xl p-8 text-center max-w-sm mx-4 shadow-2xl">
                        <div class="w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <div class="font-bold text-lg mb-1">Processing Payment</div>
                        <p class="text-gray-500 text-sm">Please wait while we process your payment...</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
let selectedPayment = '';
let stripe, cardElement, paypalButtons;

const stripeKey = '{{ $stripeKey }}';
const paypalClientId = '{{ $paypalClientId }}';
const planPrice = {{ $plan['price'] }};
const planId = '{{ $plan['id'] }}';

function selectPayment(method) {
    selectedPayment = method;
    document.getElementById('payment-method-input').value = method;
    document.querySelectorAll('.payment-option').forEach(el => {
        el.classList.remove('border-orange-500', 'bg-orange-50');
        el.classList.add('border-gray-200');
    });
    const btn = document.getElementById('btn-' + method);
    btn.classList.remove('border-gray-200');
    btn.classList.add('border-orange-500', 'bg-orange-50');

    document.getElementById('stripe-payment').classList.toggle('hidden', method !== 'stripe');
    document.getElementById('paypal-button-container').classList.toggle('hidden', method !== 'paypal');

    if (method === 'stripe' && !stripe) {
        initStripe();
    }
    if (method === 'paypal' && typeof paypal_sdk !== 'undefined' && !paypalButtons) {
        initPaypal();
    }
}

function initStripe() {
    if (!stripeKey || stripeKey === 'pk_test_placeholder') {
        document.getElementById('stripe-card-element').innerHTML = '<p class="text-red-400 text-sm">Stripe not configured.</p>';
        return;
    }
    stripe = Stripe(stripeKey);
    const elements = stripe.elements();
    cardElement = elements.create('card', {
        style: {
            base: { fontSize: '14px', fontFamily: 'inherit', color: '#111' },
        }
    });
    cardElement.mount('#stripe-card-element');
    cardElement.on('change', (e) => {
        document.getElementById('stripe-card-errors').textContent = e.error ? e.error.message : '';
    });
}

function initPaypal() {
    if (paypalClientId === 'placeholder') {
        document.getElementById('paypal-button-container').innerHTML = '<p class="text-red-400 text-sm">PayPal not configured.</p>';
        return;
    }
    paypalButtons = paypal_sdk.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{ amount: { value: planPrice.toFixed(2) } }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                document.getElementById('processing-overlay').classList.remove('hidden');
                submitOrder('paypal');
            });
        },
        onError: function(err) {
            showError('PayPal payment failed. Please try again.');
        }
    });
    paypalButtons.render('#paypal-button-container');
}

function showError(msg) {
    const el = document.getElementById('checkout-error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

async function submitOrder(method) {
    const email = document.getElementById('email').value;

    document.getElementById('checkout-error').classList.add('hidden');

    const csrf = document.querySelector('input[name="_token"]').value;

    const res = await fetch('{{ route("checkout.process", $plan["id"]) }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ email, payment_method: method }),
    });

    const data = await res.json();
    document.getElementById('processing-overlay').classList.add('hidden');

    if (data.success) {
        document.getElementById('checkout-form').classList.add('hidden');
        document.getElementById('success-email').textContent = data.customer?.email || email;
        document.getElementById('success-password').textContent = data.customer?.password || '';
        document.getElementById('success-plan').textContent = data.plan?.name || planId;
        document.getElementById('checkout-success').classList.remove('hidden');
    } else {
        showError(data.error || 'Payment failed. Please try again.');
    }
}

// Form submit
document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!selectedPayment) { showError('Please select a payment method.'); return; }

    document.getElementById('checkout-error').classList.add('hidden');

    if (selectedPayment === 'stripe') {
        if (!stripe || !cardElement) { showError('Stripe is not configured properly.'); return; }
        document.getElementById('processing-overlay').classList.remove('hidden');

        const csrf = document.querySelector('input[name="_token"]').value;
        const intentRes = await fetch('{{ route("checkout.stripe-intent", $plan["id"]) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const intentData = await intentRes.json();
        if (!intentData.clientSecret) {
            document.getElementById('processing-overlay').classList.add('hidden');
            showError('Failed to initialize payment. Check Stripe configuration.');
            return;
        }

        const { error, paymentIntent } = await stripe.confirmCardPayment(intentData.clientSecret, {
            payment_method: { card: cardElement },
        });

        if (error) {
            document.getElementById('processing-overlay').classList.add('hidden');
            showError(error.message);
            return;
        }

        if (paymentIntent.status === 'succeeded') {
            await submitOrder('stripe');
        }
    } else if (selectedPayment === 'paypal') {
        document.getElementById('paypal-button-container').querySelector('.paypal-buttons button')?.click();
    }
});
</script>
@endpush