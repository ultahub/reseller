<?php

namespace App\Http\Controllers;

use App\Services\UltaVpnApi;

class CustomerController extends Controller
{
    public function index(UltaVpnApi $api)
    {
        $customers = $api->getCustomers();
        return view('dashboard.customers', compact('customers'));
    }
}
