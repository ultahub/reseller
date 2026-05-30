<?php

namespace App\Http\Controllers;

use App\Services\UltaVpnApi;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(UltaVpnApi $api)
    {
        $credits = $api->getCredits();
        $customers = $api->getCustomers();
        $plans = $api->getPlans();
        $user = Session::get('ultavpn_user');

        $activeCustomers = collect($customers)->where('customer.isActive', true)->count();
        $withSubscriptions = collect($customers)->filter(fn($c) =>
            !empty($c['customer']['subscriptions'])
        )->count();

        return view('dashboard.index', compact(
            'credits', 'customers', 'plans', 'user',
            'activeCustomers', 'withSubscriptions'
        ));
    }

    public function credits(UltaVpnApi $api)
    {
        $credits = $api->getCredits();
        $customers = $api->getCustomers();
        return view('dashboard.credits', compact('credits', 'customers'));
    }
}
