<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'UltaVPN') — {{ \App\Models\Setting::where('key', 'WEBSITE_NAME')->value('value') ?? config('setup.website_name', 'UltaVPN Reseller') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/app.css" />
    @stack('head')
</head>
<body class="bg-white text-gray-900 font-sans antialiased flex min-h-screen">
    @php $isPublic = !Session::has('ultavpn_token'); @endphp
    @if(Session::has('ultavpn_token'))
        @php $role = Session::get('ultavpn_user')['role'] ?? ''; @endphp
        <aside class="w-64 bg-white border-r border-gray-200 shrink-0 transition-transform duration-300 -translate-x-full lg:translate-x-0 fixed lg:static inset-y-0 left-0 z-50" id="sidebar">
            <div class="px-4 pt-5 pb-3 h-full overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl tracking-tight">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white text-sm font-extrabold">U</span>
                        {{ \App\Models\Setting::where('key', 'WEBSITE_NAME')->value('value') ?? config('setup.website_name', 'UltaVPN Reseller') }}
                    </a>
                    <button class="text-gray-400 hover:text-gray-600 lg:hidden" id="sidebar-close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="space-y-1">
                    @if($role === 'RESELLER')
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('dashboard') || Request::is('dashboard/') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('dashboard.customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('dashboard/customers*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                            Customers
                        </a>
                        <a href="{{ route('dashboard.credits') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('dashboard/credits*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Credits
                        </a>
                        <a href="{{ route('dashboard.gateways') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('dashboard/gateways*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Payment Gateways
                        </a>
                        <a href="{{ route('dashboard.plans') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('dashboard/plans*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Plans
                        </a>
                    @elseif($role === 'CUSTOMER')
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('customer/dashboard*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            My Subscription
                        </a>
                        <a href="{{ route('customer.billing') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::is('customer/billing*') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            Billing
                        </a>
                    @endif
                </nav>
            </div>
        </aside>
        @if(Session::has('ultavpn_token'))
        <div class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden" id="sidebar-backdrop"></div>
        @endif

        <div class="flex-1 flex flex-col min-w-0">
    @else
        <div class="flex-1 flex flex-col min-w-0">
    @endif
        <nav class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if(Session::has('ultavpn_token'))
                    <button class="text-gray-500 hover:text-gray-700 lg:hidden" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    @endif
                    <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl tracking-tight">
                        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white text-sm font-extrabold">U</span>
                        {{ \App\Models\Setting::where('key', 'WEBSITE_NAME')->value('value') ?? config('setup.website_name', 'UltaVPN Reseller') }}
                    </a>
                </div>
                <div class="flex items-center gap-1 sm:gap-2 text-sm font-medium">
                    @if(Session::has('ultavpn_token'))
                        @php $role = Session::get('ultavpn_user')['role'] ?? ''; @endphp
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:text-orange-500 hover:bg-orange-50 transition">Home</a>
                        <a href="{{ route('pricing') }}" class="px-3 py-2 rounded-lg hover:text-orange-500 hover:bg-orange-50 transition">Pricing</a>
                         @if($role === 'RESELLER')
                             <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg hover:text-orange-500 hover:bg-orange-50 transition">Dashboard</a>
                         @elseif($role === 'CUSTOMER')
                             <a href="{{ route('customer.dashboard') }}" class="px-3 py-2 rounded-lg hover:text-orange-500 hover:bg-orange-50 transition">My Subscription</a>
                         @endif
                         <form method="POST" action="{{ route('logout') }}" class="inline">
                             @csrf
                             <button type="submit" class="px-3 py-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">Logout</button>
                         </form>
                     @else
                        <div class="hidden md:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition">Home</a>
                            <a href="{{ route('pricing') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition">Pricing</a>
                            <a href="{{ route('login') }}" class="ml-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-orange-200 transition shadow-md">Login</a>
                        </div>
                        <button class="md:hidden text-gray-600 p-1" id="mobile-menu-open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                     @endif
                 </div>
            </div>
            @if($isPublic)
            <div class="hidden border-t border-gray-100 bg-white" id="mobile-menu">
                <div class="px-4 py-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition text-sm font-medium">Home</a>
                    <a href="{{ route('pricing') }}" class="block px-3 py-2.5 rounded-lg text-gray-600 hover:text-orange-500 hover:bg-orange-50 transition text-sm font-medium">Pricing</a>
                    <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 text-white text-sm font-semibold text-center mt-2">Login</a>
                </div>
            </div>
            @endif
        </nav>

        <main class="flex-1">
            @yield('content')
        </main>

    @unless(request()->routeIs('dashboard.*'))
    <footer class="border-t border-gray-100 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 font-bold text-lg mb-4">
                        <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white text-xs font-extrabold">U</span>
                        {{ \App\Models\Setting::where('key', 'WEBSITE_NAME')->value('value') ?? config('setup.website_name', 'UltaVPN Reseller') }}
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed">White-label VPN reseller platform. Sell premium VPN under your own brand.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-gray-900 mb-3">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('pricing') }}" class="hover:text-orange-500 transition">Pricing</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-orange-500 transition">Features</a></li>
                        <li><a href="#" class="hover:text-orange-500 transition">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-gray-900 mb-3">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="https://ultavpn.com" class="hover:text-orange-500 transition">UltaVPN</a></li>
                        <li><a href="https://ultavpn.com/contact" class="hover:text-orange-500 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-gray-900 mb-3">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="https://ultavpn.com/docs" class="hover:text-orange-500 transition">Documentation</a></li>
                        <li><a href="mailto:support@ultavpn.com" class="hover:text-orange-500 transition">support@ultavpn.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-8 text-center text-gray-400 text-xs">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::where('key', 'WEBSITE_NAME')->value('value') ?? config('setup.website_name', 'UltaVPN Reseller') }}. All rights reserved.
            </div>
        </div>
    </footer>
    @endunless

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOpen = document.getElementById('sidebar-open');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarBackdrop = document.getElementById('sidebar-backdrop');

            if (sidebarOpen && sidebar) {
                sidebarOpen.addEventListener('click', function() {
                    sidebar.classList.remove('-translate-x-full');
                    if (sidebarBackdrop) sidebarBackdrop.classList.remove('hidden');
                });
            }
            function closeSidebar() {
                if (sidebar) sidebar.classList.add('-translate-x-full');
                if (sidebarBackdrop) sidebarBackdrop.classList.add('hidden');
            }
            if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
            if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);

            const mobileMenu = document.getElementById('mobile-menu');
            const menuBtn = document.getElementById('mobile-menu-open');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>