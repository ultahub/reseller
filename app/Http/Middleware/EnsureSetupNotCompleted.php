<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSetupNotCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $setupCompleted = \App\Models\Setting::where('key', 'SETUP_COMPLETED')->value('value') === 'true';
        } catch (\Exception $e) {
            $setupCompleted = false;
        }

        if ($setupCompleted || config('setup.completed')) {
            return redirect('/');
        }

        return $next($request);
    }
}
