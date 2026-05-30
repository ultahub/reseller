@extends('layouts.app')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden pt-16 pb-20 sm:pt-24 sm:pb-28">
    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-white to-amber-50 pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-gradient-to-br from-orange-200/20 to-amber-200/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-20 right-0 w-72 h-72 bg-orange-100/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-amber-100/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 relative">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 border border-orange-200/50">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                Reseller Partner Program
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] mb-6">
                Sell Premium VPN<br/>
                <span class="bg-gradient-to-r from-orange-500 to-amber-500 bg-clip-text text-transparent">Under Your Brand</span>
            </h1>
            <p class="text-gray-500 text-lg sm:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                Start your own VPN business with zero infrastructure. Buy credits at wholesale, create customers,
                and earn recurring revenue — all powered by UltaVPN&rsquo;s global network.
            </p>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-8 py-3.5 rounded-xl text-base font-bold hover:shadow-xl hover:shadow-orange-200/50 transition shadow-lg shadow-orange-200/30">
                    View Plans &amp; Pricing
                </a>
                <a href="{{ route('login') }}" class="border-2 border-gray-200 text-gray-700 px-8 py-3.5 rounded-xl text-base font-bold hover:border-orange-300 hover:text-orange-600 transition">
                    Sign In
                </a>
            </div>
        </div>

        {{-- Hero stats --}}
        <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-6 max-w-3xl mx-auto" x-data="statsCounter()" x-init="init()">
            @php $stats = [['200+', 'Countries', '200'], ['99.9%', 'Uptime', '99.9'], ['50Mbps+', 'Speed', '50'], ['24/7', 'Support', '24']]; @endphp
            @foreach($stats as $s)
            <div class="text-center p-4">
                <div class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                    <span x-text="counts[{{ $loop->index }}]">{{ $s[0] }}</span>
                </div>
                <div class="text-sm text-gray-500 mt-1">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="py-20 sm:py-28 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                Simple Process
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">How It Works</h2>
            <p class="text-gray-500 max-w-lg mx-auto">From zero to selling in minutes. No technical skills required.</p>
        </div>
        <div class="grid sm:grid-cols-4 gap-8">
            @php
                $steps = [
                    ['1', 'Create Account', 'Sign up as a reseller and generate your API key from the UltaVPN dashboard.'],
                    ['2', 'Buy Credits', 'Purchase credit packs at wholesale prices. 1 credit = 1 month of VPN access for one customer.'],
                    ['3', 'Integrate', 'Use our Laravel template or REST API to launch your branded VPN store.'],
                    ['4', 'Sell & Earn', 'Your customers pay you. We handle servers, infrastructure, and support.'],
                ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="relative group">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 text-white flex items-center justify-center text-xl font-extrabold mb-5 shadow-lg shadow-orange-200/40 group-hover:scale-110 group-hover:-translate-y-1 transition">
                    {{ $step[0] }}
                </div>
                <h3 class="font-bold text-lg mb-2">{{ $step[1] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step[2] }}</p>
                @if(!$loop->last)
                <div class="hidden sm:block absolute top-7 left-16 w-[calc(100%-3rem)] h-px bg-gradient-to-r from-orange-200 to-transparent"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Devices Support --}}
<section class="py-20 sm:py-28 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                Multi-Platform
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Works on Every Device</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Protect all your devices with a single subscription.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 max-w-3xl mx-auto">
            @php
                $devices = [
                    ['windows', 'Windows', 'M3.354 4.646a.5.5 0 00-.354-.146H5.5a.5.5 0 000 1h.793L3.146 8.646a.5.5 0 00.708.708L7 6.207V7a.5.5 0 001 0V5.5a.5.5 0 00-.5-.5H5.5a.5.5 0 00-.5.5v.793L3.354 4.646z'],
                    ['apple', 'macOS & iOS', 'M11.5 0C10.12 0 8.5.8 7.5 2.1 6.6 3.3 6 5.1 6.2 6.8c1.8.1 3.5-1 4.5-2.3 1-1.3 1.5-3 1.3-4.5zM8.8 7.2c-1.8 0-3.3 1-4.8 1-1.5 0-3.1-1-5.1-1C-2.5 7.2 0 13 2 14.5c1 .7 1.8 1 2.8 1 1 0 1.7-.5 2.8-.5 1.1 0 1.8.5 2.8.5s2-.4 2.8-1c2.2-1.6 3.8-5.2 4-5.8-.8-.4-2.8-1.6-2.8-4.2 0-2.2 1.8-3.2 2.2-3.5-1.2-1.8-3.2-2-3.8-2-1.8-.2-3.2 1-3.8 1z'],
                    ['android', 'Android', 'M17.523 16.606l-7.56 4.365a.5.5 0 01-.474 0L1.9 16.606a.5.5 0 01-.263-.456V7.852a.5.5 0 01.263-.455l7.56-4.366a.5.5 0 01.474 0l7.56 4.366a.5.5 0 01.263.455v8.298a.5.5 0 01-.234.456z'],
                    ['linux', 'Linux', 'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 2c4.418 0 8 3.582 8 8 0 1.848-.63 3.546-1.688 4.905L12 12V4zm0 4l6.38 6.38C17.348 15.982 15.347 17 12 17s-5.348-1.018-6.38-2.62L12 8z'],
                ];
            @endphp
            @foreach($devices as $d)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 text-center hover:border-orange-200 hover:shadow-lg hover:shadow-orange-50 transition">
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $d[2] }}"/>
                    </svg>
                </div>
                <span class="font-semibold text-sm">{{ $d[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Features --}}
<section class="py-20 sm:py-28 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                Why Choose Us
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Everything You Need to Succeed</h2>
            <p class="text-gray-500 max-w-lg mx-auto">We provide the infrastructure, you build the brand.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $features = [
                    ['credit', 'Credit-Based Billing', 'Buy credits at wholesale and use them to create customer subscriptions. No monthly commitments, pay as you grow.', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['shield', 'Fully Managed', 'We handle 200+ servers, global infrastructure, and 24/7 technical support. You focus on selling.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['pricing', 'Your Own Pricing', 'Set your own rates, brand the entire experience, and keep the margin. Integrate via our REST API or use our template.', 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
                    ['globe', 'Global Network', 'Servers in 200+ locations across 95 countries. Enterprise-grade infrastructure with 99.9% uptime guarantee.', 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['devices', 'Multi-Device', 'Each subscription covers unlimited devices. Your customers get simultaneous connections on all their devices.', 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ['api', 'REST API', 'Full-featured API to create customers, manage subscriptions, check credits, and automate your entire operation.', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                ];
            @endphp
            @foreach($features as $f)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-200 hover:shadow-lg hover:shadow-orange-50 transition group">
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-orange-200 transition">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f[3] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-base mb-2">{{ $f[1] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Server Map Visualization --}}
<section class="py-20 sm:py-28 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                Global Infrastructure
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">200+ Servers Worldwide</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Enterprise-grade infrastructure across 95 countries.</p>
        </div>
        <div class="relative max-w-4xl mx-auto aspect-[2/1] bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xl">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_#f97316_0%,_transparent_60%)] opacity-5"></div>
            <div class="absolute inset-0 p-6 sm:p-10">
                <div class="w-full h-full relative">
                    @php
                        $locations = [
                            [18, 35], [25, 30], [30, 25], [35, 20], [42, 28], [48, 22], [52, 18], [55, 35],
                            [60, 40], [65, 25], [70, 30], [72, 15], [75, 35], [78, 28], [82, 20], [85, 32],
                        ];
                    @endphp
                    @foreach($locations as $loc)
                    <div class="absolute w-3 h-3 -ml-1.5 -mt-1.5" style="left: {{ $loc[0] }}%; top: {{ $loc[1] }}%">
                        <div class="w-3 h-3 rounded-full bg-orange-500 animate-ping absolute opacity-75"></div>
                        <div class="w-3 h-3 rounded-full bg-orange-500 relative"></div>
                    </div>
                    @endforeach
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-5xl font-extrabold text-gray-900/10">GLOBAL</div>
                            <div class="text-sm text-gray-300 mt-1">200+ locations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Dashboard Preview --}}
<section class="py-20 sm:py-28 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">
                    Powerful Dashboard
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Full Control at Your Fingertips</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Manage your entire reseller operation from one place. Track credits, create customers,
                    monitor subscriptions, and configure payment gateways — all from a clean, intuitive dashboard.
                </p>
                <div class="space-y-4">
                    @php
                        $items = [
                            'Real-time credit balance and usage tracking',
                            'Create and manage customer subscriptions',
                            'View subscription status and renewal dates',
                            'Configure Stripe and PayPal payment gateways',
                            'Detailed analytics and transaction history',
                        ];
                    @endphp
                    @foreach($items as $item)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('pricing') }}" class="mt-8 inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-3 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition">
                    Get Started
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
            <div class="relative">
                <div class="aspect-[4/3] bg-gray-100 rounded-2xl border border-gray-200 overflow-hidden shadow-2xl">
                    <div class="h-10 bg-gray-50 border-b border-gray-200 flex items-center px-4 gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-400"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        <span class="w-3 h-3 rounded-full bg-green-400"></span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="h-4 w-32 bg-gray-200 rounded"></div>
                            <div class="h-8 w-24 bg-orange-100 rounded-lg"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="h-20 bg-gray-50 rounded-xl p-3"><div class="h-3 w-16 bg-gray-200 rounded mb-2"></div><div class="h-5 w-12 bg-gray-300 rounded"></div></div>
                            <div class="h-20 bg-gray-50 rounded-xl p-3"><div class="h-3 w-16 bg-gray-200 rounded mb-2"></div><div class="h-5 w-16 bg-gray-300 rounded"></div></div>
                            <div class="h-20 bg-gray-50 rounded-xl p-3"><div class="h-3 w-16 bg-gray-200 rounded mb-2"></div><div class="h-5 w-8 bg-gray-300 rounded"></div></div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-12 bg-gray-50 rounded-xl"></div>
                            <div class="h-12 bg-gray-50 rounded-xl"></div>
                            <div class="h-12 bg-gray-50 rounded-xl"></div>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-gradient-to-br from-orange-200 to-amber-200 rounded-full blur-2xl opacity-60 pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials / Trust --}}
<section class="py-20 sm:py-28 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Trusted by Resellers Worldwide</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Join hundreds of resellers already building their VPN business.</p>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    ['Sarah K.', 'Digital Agency Owner', 'I launched my branded VPN service in under an hour. The credit system is brilliant — no monthly fees, just pay for what I use.'],
                    ['Marcus T.', 'Freelance Developer', 'The REST API is clean and well-documented. I integrated everything into my existing platform in a single afternoon.'],
                    ['Priya R.', 'E-commerce Entrepreneur', 'My customers love the seamless experience. I set my own prices and the recurring revenue has been a game-changer for my business.'],
                ];
            @endphp
            @foreach($testimonials as $t)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg hover:border-orange-100 transition">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">&ldquo;{{ $t[2] }}&rdquo;</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center text-white text-xs font-bold">{{ substr($t[0], 0, 1) }}</div>
                    <div>
                        <div class="text-sm font-semibold">{{ $t[0] }}</div>
                        <div class="text-xs text-gray-400">{{ $t[1] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-20 sm:py-28 bg-white">
    <div class="max-w-3xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Everything you need to know about the reseller program.</p>
        </div>
        <div class="space-y-3" x-data="{ open: null }">
            @php
                $faqs = [
                    ['How does credit-based billing work?', 'Buy credit packs at wholesale prices. Each credit equals one month of VPN access for one customer. Deduct credits when creating or renewing subscriptions. No recurring fees — you only pay for what you sell.'],
                    ['Can I set my own prices?', 'Absolutely. You have full control over your pricing. Set monthly, quarterly, or annual rates. Your customers pay you directly through your integrated Stripe or PayPal gateways.'],
                    ['What infrastructure do I need?', 'None. UltaVPN manages the entire VPN infrastructure — servers in 200+ locations, global network, DNS, and 24/7 technical support. You just need a domain name and our ready-to-deploy Laravel template.'],
                    ['How do payment gateways work?', 'Configure your own Stripe and PayPal accounts in the dashboard. Your customers pay you directly. Funds go to your accounts instantly. We never touch your revenue.'],
                    ['Is there a minimum commitment?', 'No minimum commitment, no monthly fees. Buy credits as you need them. Start small and scale up as your customer base grows. There are no long-term contracts.'],
                    ['Can I white-label the entire experience?', 'Yes. Our Laravel template uses your brand name, logo, and colors throughout. The checkout flow, customer portal, and even email communications carry your brand.'],
                ];
            @endphp
            @foreach($faqs as $i => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden transition hover:border-orange-200" :class="open === {{ $i }} ? 'border-orange-200 shadow-sm' : ''">
                <button
                    @click="open = open === {{ $i }} ? null : {{ $i }}"
                    class="w-full flex items-center justify-between px-6 py-4 text-left font-semibold text-sm hover:bg-gray-50 transition"
                >
                    <span>{{ $faq[0] }}</span>
                    <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="open === {{ $i }} ? 'rotate-180 text-orange-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-4 text-sm text-gray-500 leading-relaxed">
                    {{ $faq[1] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 sm:py-28 bg-gradient-to-br from-orange-500 to-amber-500 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyek0zNiAyNHYySDI0di0yaDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
    <div class="max-w-3xl mx-auto px-4 text-center relative">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Ready to Start Your VPN Business?</h2>
        <p class="text-orange-100 text-lg mb-10 max-w-lg mx-auto leading-relaxed">
            Join our reseller program and launch your branded VPN service today. No infrastructure, no minimums, no hassle.
        </p>
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <a href="{{ route('pricing') }}" class="bg-white text-orange-600 px-8 py-3.5 rounded-xl text-base font-bold hover:shadow-xl hover:shadow-orange-900/20 transition shadow-lg">
                Browse Plans
            </a>
            <a href="{{ route('login') }}" class="border-2 border-white/30 text-white px-8 py-3.5 rounded-xl text-base font-bold hover:border-white/60 transition">
                Sign In
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function statsCounter() {
    return {
        counts: ['0', '0', '0', '0'],
        targets: ['200+', '99.9%', '50Mbps+', '24/7'],
        init() {
            const nums = [200, 99.9, 50, 24];
            nums.forEach((target, i) => {
                let current = 0;
                const step = Math.max(1, Math.floor(target / 60));
                const interval = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(interval);
                    }
                    if (i === 1) {
                        this.counts[i] = current.toFixed(1) + '%';
                    } else if (i === 2) {
                        this.counts[i] = Math.floor(current) + 'Mbps+';
                    } else {
                        this.counts[i] = Math.floor(current) + (i === 0 ? '+' : '/7');
                    }
                }, 30);
            });
        }
    };
}
</script>
@endpush