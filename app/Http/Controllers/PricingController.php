<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\UltaVpnApi;

class PricingController extends Controller
{
    public function index(UltaVpnApi $api)
    {
        $localPlans = Plan::where('is_active', true)->orderBy('price')->get();

        if ($localPlans->isNotEmpty()) {
            $plans = $localPlans->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'durationDays' => $p->duration_days,
                'bandwidthGb' => $p->bandwidth_gb,
                'deviceLimit' => $p->device_limit,
                'price' => (float) $p->price,
            ])->toArray();
        } else {
            $plans = $api->getPlans();
        }

        return view('pricing', compact('plans'));
    }
}
