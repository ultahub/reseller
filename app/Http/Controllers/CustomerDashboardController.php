<?php

namespace App\Http\Controllers;

use App\Services\UltaVpnApi;
use Illuminate\Support\Facades\Session;

class CustomerDashboardController extends Controller
{
    public function index(UltaVpnApi $api)
    {
        $subscription = $api->getCustomerSubscription();
        $plans = $api->getPlans();
        $user = Session::get('ultavpn_user');

        return view('customer.dashboard', compact('subscription', 'plans', 'user'));
    }
}
