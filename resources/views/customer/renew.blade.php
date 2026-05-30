@extends('layouts.app')

@section('title', 'Renew Subscription')

@push('head')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=USD" data-namespace="paypal_sdk"></script>
@endpush

@section('content')

<section class="max-w-4xl mx-auto px-4 pt-16 pb-24">
    <div class="grid lg:grid-cols-5 gap-10">

        {{-- Order Summary --}}
        <div class="lg:col-span-2">
            <div class="border border-gray-200 rounded-2xl p-6 sticky top-24">
                <h3 class="font-bold text-lg mb-4">Renewal Summary</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center font-bold text-orange-600">{{ substr($plan['name'], 0, 2) }}</div>
                    <div>
                        <div class="font-semibold">{{ $plan['name'] }}</div>
                        <div class="text-sm text-gray-400">{{ $plan['durationDays'] }} days &middot; {{ $plan['bandwidthGb'] }} GB</div>
                    </div>
                </div>
                @if($currentSubscription)
                    @php $end = new DateTime($currentSubscription['endDate']); @endphp
                    <div class="text-xs text-gray-400 mb-4">Extends current sub (expires {{ $end->format('M j, Y') }})</div>
                @endif
                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-semibold">${{ number_format($plan['price'], 2) }}</span></div>
                    <div class="flex justify-between border-t border-gray-100 pt-2"><span class="font-bold">Total</span><span class="font-bold text-lg">${{ number_format($plan['price'], 2) }}</span></div>
                </div>
            </div>
        </div>

        {{-- Payment Form --}}
        <div class="lg:col-span-3">
            <div class="border border-gray-200 rounded-2xl p-8">
                <h2 class="text-xl font-bold mb-6">Payment</h2>

                <div id="checkout-error" class="bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl px-4 py-3 mb-6 hidden"></div>
                <div id="checkout-success" class="bg-green-50 border border-green-100 text-green-600 text-sm rounded-xl px-4 py-3 mb-6 hidden"></div>

                <form id="renew-form">
                    @csrf
                    <input type="hidden" name="payment_method" id="payment-method-input" value="" />

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

                    {{-- Stripe Card --}}
                    <div id="stripe-payment" class="hidden mb-6">
                        <label class="block text-sm font-semibold mb-2 text-gray-700">Card Details</label>
                        <div id="stripe-card-element" class="border border-gray-200 rounded-xl px-4 py-3"></div>
                        <div id="stripe-card-errors" class="text-red-500 text-xs mt-1"></div>
                    </div>

                    {{-- PayPal --}}
                    <div id="paypal-button-container" class="hidden mb-6"></div>

                    <button type="submit" id="submit-btn"
                            class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-orange-200 transition disabled:opacity-50">
                        Pay ${{ number_format($plan['price'], 2) }}
                    </button>
                </form>

                <div id="processing-overlay" class="hidden fixed inset-0 bg-black/30 flex items-center justify-center z-50">
                    <div class="bg-white rounded-2xl p-8 text-center max-w-sm mx-4 shadow-2xl">
                        <div class="w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <div class="font-bold text-lg mb-1">Processing Payment</div>
                        <p class="text-gray-500 text-sm">Please wait...</p>
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

    if (method === 'stripe' && !stripe) initStripe();
    if (method === 'paypal' && typeof paypal_sdk !== 'undefined' && !paypalButtons) initPaypal();
}

function initStripe() {
    if (!stripeKey || stripeKey === 'pk_test_placeholder') {
        document.getElementById('stripe-card-element').innerHTML = '<p class="text-red-400 text-sm">Stripe not configured.</p>';
        return;
    }
    stripe = Stripe(stripeKey);
    const elements = stripe.elements();
    cardElement = elements.create('card', {
        style: { base: { fontSize: '14px', fontFamily: 'inherit', color: '#111' } }
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
            return actions.order.create({ purchase_units: [{ amount: { value: planPrice.toFixed(2) } }] });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function() {
                document.getElementById('processing-overlay').classList.remove('hidden');
                submitRenew('paypal');
            });
        },
        onError: function() { showError('PayPal payment failed.'); }
    });
    paypalButtons.render('#paypal-button-container');
}

function showError(msg) {
    document.getElementById('checkout-error').textContent = msg;
    document.getElementById('checkout-error').classList.remove('hidden');
}

async function submitRenew(method) {
    document.getElementById('checkout-error').classList.add('hidden');
    document.getElementById('checkout-success').classList.add('hidden');

    const csrf = document.querySelector('input[name="_token"]').value;
    const res = await fetch('{{ route("customer.renew.process", $plan["id"]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ payment_method: method }),
    });

    const data = await res.json();
    document.getElementById('processing-overlay').classList.add('hidden');

    if (data.success) {
        document.getElementById('renew-form').classList.add('hidden');
        document.getElementById('checkout-success').innerHTML = `
            <div class="text-center py-4">
                <div class="text-4xl mb-3">🎉</div>
                <div class="font-bold text-lg text-green-700 mb-1">Subscription Renewed!</div>
                <p class="text-green-600 mb-4">Your subscription has been extended.</p>
                <a href="{{ route('customer.dashboard') }}" class="inline-block bg-green-600 text-white rounded-lg px-5 py-2 text-sm font-bold">Back to Dashboard</a>
            </div>
        `;
        document.getElementById('checkout-success').classList.remove('hidden');
    } else {
        showError(data.error || 'Renewal failed. Please try again.');
    }
}

document.getElementById('renew-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!selectedPayment) { showError('Please select a payment method.'); return; }

    document.getElementById('checkout-error').classList.add('hidden');
    document.getElementById('checkout-success').classList.add('hidden');

    if (selectedPayment === 'stripe') {
        if (!stripe || !cardElement) { showError('Stripe is not configured.'); return; }
        document.getElementById('processing-overlay').classList.remove('hidden');

        const csrf = document.querySelector('input[name="_token"]').value;
        const intentRes = await fetch('{{ route("customer.renew.stripe-intent", $plan["id"]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        const intentData = await intentRes.json();
        if (!intentData.clientSecret) {
            document.getElementById('processing-overlay').classList.add('hidden');
            showError('Failed to initialize payment.');
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
            await submitRenew('stripe');
        }
    } else if (selectedPayment === 'paypal') {
        document.getElementById('paypal-button-container').querySelector('.paypal-buttons button')?.click();
    }
});
</script>
@endpush
