<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('price')->get();
        return view('dashboard.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('dashboard.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:3650'],
            'bandwidth_gb' => ['required', 'integer', 'min:1', 'max:99999'],
            'device_limit' => ['required', 'integer', 'min:1', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999'],
        ]);

        try {
            Plan::create($validated + ['is_active' => true]);
            return redirect()->route('dashboard.plans')->with('success', 'Plan created successfully!');
        } catch (\Exception $e) {
            Log::error('Plan creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create plan: ' . $e->getMessage());
        }
    }

    public function edit(Plan $plan)
    {
        return view('dashboard.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:3650'],
            'bandwidth_gb' => ['required', 'integer', 'min:1', 'max:99999'],
            'device_limit' => ['required', 'integer', 'min:1', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999'],
        ]);

        try {
            $plan->update($validated);
            return redirect()->route('dashboard.plans')->with('success', 'Plan updated successfully!');
        } catch (\Exception $e) {
            Log::error('Plan update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update plan: ' . $e->getMessage());
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();
            return redirect()->route('dashboard.plans')->with('success', 'Plan deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Plan deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete plan: ' . $e->getMessage());
        }
    }

    public function toggle(Plan $plan)
    {
        try {
            $plan->update(['is_active' => !$plan->is_active]);
            $status = $plan->is_active ? 'activated' : 'deactivated';
            return redirect()->route('dashboard.plans')->with('success', "Plan {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to toggle plan: ' . $e->getMessage());
        }
    }
}
