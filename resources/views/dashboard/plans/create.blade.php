@extends('layouts.app')

@section('title', 'Add Plan')

@section('content')
<section class="max-w-2xl mx-auto px-4 pt-16 pb-24">
    <div class="mb-8">
        <a href="{{ route('dashboard.plans') }}" class="text-gray-500 hover:text-orange-600 text-sm font-medium inline-flex items-center gap-1 mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Plans
        </a>
        <h1 class="text-3xl font-extrabold">Add VPN Plan</h1>
        <p class="text-gray-500">Create a new plan for your pricing page</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 rounded-xl px-5 py-4 text-sm text-red-700 flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.plans.store') }}" method="POST" class="bg-white border border-gray-200 rounded-2xl p-8 space-y-6 shadow-sm">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Plan Name <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Starter, Pro, Enterprise" required
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            <p class="text-xs text-gray-400 mt-1.5">A descriptive name for your VPN plan</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="duration_days" class="block text-sm font-semibold text-gray-700 mb-2">Duration (days) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', 30) }}" min="1" max="3650" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">days</span>
                </div>
            </div>
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">$</span>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" max="99999" placeholder="0.00" required
                           class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="bandwidth_gb" class="block text-sm font-semibold text-gray-700 mb-2">Bandwidth <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" id="bandwidth_gb" name="bandwidth_gb" value="{{ old('bandwidth_gb', 100) }}" min="1" max="99999" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">GB</span>
                </div>
            </div>
            <div>
                <label for="device_limit" class="block text-sm font-semibold text-gray-700 mb-2">Device Limit <span class="text-red-500">*</span></label>
                <input type="number" id="device_limit" name="device_limit" value="{{ old('device_limit', 5) }}" min="1" max="100" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <p class="text-xs text-gray-400 mt-1.5">Max devices per subscription</p>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:shadow-orange-200 transition shadow-md inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Plan
            </button>
        </div>
    </form>
</section>
@endsection