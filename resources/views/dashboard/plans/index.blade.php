@extends('layouts.app')

@section('title', 'Plans')

@section('content')
<section class="max-w-5xl mx-auto px-4 pt-16 pb-24">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold">VPN Plans</h1>
            <p class="text-gray-500">Manage your subscription plans displayed on the pricing page</p>
        </div>
        <a href="{{ route('dashboard.plans.create') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-orange-200 transition inline-flex items-center gap-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Plan
        </a>
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

    @if(count($plans) === 0)
        <div class="text-center py-20 text-gray-400 border-2 border-dashed border-gray-200 rounded-2xl">
            <svg class="w-14 h-14 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-lg font-medium text-gray-500 mb-1">No plans yet</p>
            <p class="text-sm text-gray-400">Create your first VPN plan to display on the pricing page.</p>
        </div>
    @else
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 mb-6">
            @foreach($plans as $plan)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition relative {{ !$plan->is_active ? 'opacity-60' : '' }}">
                    @if($plan->is_active)
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Active
                            </span>
                        </div>
                    @else
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Inactive
                            </span>
                        </div>
                    @endif
                    <div class="text-2xl font-extrabold mb-1">{{ $plan->name }}</div>
                    <div class="text-3xl font-black mb-4">${{ number_format($plan->price, 2) }}</div>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <span>Duration</span>
                            <span class="font-semibold text-gray-800">{{ $plan->duration_days }} days</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Bandwidth</span>
                            <span class="font-semibold text-gray-800">{{ $plan->bandwidth_gb }} GB</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Devices</span>
                            <span class="font-semibold text-gray-800">{{ $plan->device_limit }}</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                        <a href="{{ route('dashboard.plans.edit', $plan) }}" class="text-gray-400 hover:text-orange-600 transition p-1.5 rounded-lg hover:bg-orange-50" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <a href="{{ route('dashboard.plans.toggle', $plan) }}" class="text-gray-400 hover:text-orange-600 transition p-1.5 rounded-lg hover:bg-orange-50" title="{{ $plan->is_active ? 'Deactivate' : 'Activate' }}">
                            @if($plan->is_active)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            @endif
                        </a>
                        <form action="{{ route('dashboard.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete this plan?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1.5 rounded-lg hover:bg-red-50" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection