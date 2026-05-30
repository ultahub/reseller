<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CheckSetupStatus
{
    /**
     * Handle an incoming request.
     * Redirect to setup if setup is not completed or API key is missing.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setupCompleted = false;
        $apiKey = null;

        try {
            $dbSetup = \App\Models\Setting::where('key', 'SETUP_COMPLETED')->value('value') === 'true';
            if ($dbSetup) {
                $setupCompleted = true;
            }
        } catch (\Exception $e) {
            // Database not available yet
        }

        // Fall back to .env config
        if (!$setupCompleted && config('setup.completed')) {
            $setupCompleted = true;
        }

        try {
            $dbApiKey = \App\Models\Setting::where('key', 'ULTAVPN_API_KEY')->value('value');
            if ($dbApiKey) {
                $apiKey = $dbApiKey;
            }
        } catch (\Exception $e) {
            // Database not available yet
        }

        // Fall back to .env config
        $apiKey = $apiKey ?: config('ultavpn.api_key');

        // If setup is completed and API key exists, allow access
        if ($setupCompleted && !empty($apiKey)) {
            return $next($request);
        }

        // Otherwise, redirect to setup
        return redirect()->route('setup.show');
    }
}