<?php

namespace App\Http\Controllers;

use App\Services\UltaVpnApi;
use Illuminate\Support\Facades\Session;

class BillingController extends Controller
{
    public function index(UltaVpnApi $api)
    {
        $subscription = $api->getCustomerSubscription();
        $plans = $api->getPlans();
        $user = Session::get('ultavpn_user');

        return view('customer.billing', compact('subscription', 'plans', 'user'));
    }
}