<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('ultavpn_token')) {
            return redirect()->route('login');
        }
        $role = Session::get('ultavpn_user')['role'] ?? '';
        if ($role !== 'CUSTOMER') {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
