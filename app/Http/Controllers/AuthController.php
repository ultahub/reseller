<?php

namespace App\Http\Controllers;

use App\Services\UltaVpnApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Session::has('ultavpn_token')) {
            $role = Session::get('ultavpn_user')['role'] ?? '';
            return $role === 'RESELLER'
                ? redirect()->route('dashboard')
                : redirect()->route('customer.dashboard');
        }
        return view('login');
    }

    public function login(Request $request, UltaVpnApi $api)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $api->login($request->email, $request->password);

        if (!$result || !isset($result['user'])) {
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }

        Session::put('ultavpn_token', $result['token']);
        Session::put('ultavpn_user', $result['user']);

        $role = $result['user']['role'] ?? '';

        if ($role === 'RESELLER') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    public function logout()
    {
        Session::forget(['ultavpn_token', 'ultavpn_user']);
        return redirect()->route('home');
    }
}
