<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SetupController extends Controller
{
    public function show(Request $request)
    {
        try {
            if (config('setup.completed') || Setting::where('key', 'SETUP_COMPLETED')->value('value') === 'true') {
                return redirect('/');
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet, setup not completed
        }

        $siteUrl = request()->getSchemeAndHttpHost();
        return view('setup', compact('siteUrl'));
    }

    public function store(Request $request)
    {
        try {
            if (config('setup.completed') || Setting::where('key', 'SETUP_COMPLETED')->value('value') === 'true') {
                return redirect('/');
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet, setup not completed
        }

        $validated = $request->validate([
            'website_name' => ['required', 'string', 'max:100'],
            'api_key' => ['required', 'string', 'min:10'],
        ]);

        $apiUrl = 'https://ultavpn.com';
        $siteUrl = request()->getSchemeAndHttpHost();

        // Validate API connection
        try {
            $validation = $this->validateApiKey($apiUrl, $validated['api_key']);
            if (!$validation['success']) {
                return back()->withInput()->with('error', $validation['message']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'API validation error: ' . $e->getMessage());
        }

        // Run migrations on SQLite
        try {
            \Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            Log::error('Migration failed: ' . $e->getMessage());
        }

        // Save settings to database
        try {
            Setting::updateOrCreate(['key' => 'SETUP_COMPLETED'], ['value' => 'true']);
            Setting::updateOrCreate(['key' => 'WEBSITE_NAME'], ['value' => $validated['website_name']]);
            Setting::updateOrCreate(['key' => 'ULTAVPN_API_KEY'], ['value' => $validated['api_key']]);
            Setting::updateOrCreate(['key' => 'ULTAVPN_API_URL'], ['value' => $apiUrl]);
        } catch (\Exception $e) {
            Log::error('Failed to save setup settings: ' . $e->getMessage());
        }

        // Also save to .env
        try {
            $this->updateEnv([
                'APP_URL' => $siteUrl,
                'ULTAVPN_API_KEY' => $validated['api_key'],
                'ULTAVPN_API_URL' => $apiUrl,
                'WEBSITE_NAME' => $validated['website_name'],
                'SETUP_COMPLETED' => 'true',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update .env: ' . $e->getMessage());
        }

        \Artisan::call('config:clear');

        return redirect('/')
            ->with('success', 'Setup completed successfully! Welcome to ' . $validated['website_name']);
    }

    public function testConnection(Request $request)
    {
        $validated = $request->validate([
            'api_key' => ['required', 'string', 'min:10'],
        ]);
        $validation = $this->validateApiKey('https://ultavpn.com', $validated['api_key']);
        return response()->json($validation);
    }

    private function validateApiKey(string $apiUrl, string $apiKey): array
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ])->timeout(10)->get(rtrim($apiUrl, '/') . '/api/v1/reseller/credits');

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data']['credits']) || isset($data['data'])) {
                    return ['success' => true, 'message' => 'API key is valid'];
                }
            }
            return ['success' => false, 'message' => 'API key validation failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Could not connect to API: ' . $e->getMessage()];
        }
    }

    private function updateEnv(array $values): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) throw new \Exception('.env file not found');
        $envContent = file_get_contents($envPath);
        foreach ($values as $key => $value) {
            $quotedValue = (strpos($value, ' ') !== false || strpos($value, '=') !== false)
                ? '"' . str_replace('"', '\\"', $value) . '"'
                : $value;
            $pattern = "/^" . preg_quote($key, '/') . "=.*/m";
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $key . "=" . $quotedValue, $envContent);
            } else {
                $envContent .= "\n" . $key . "=" . $quotedValue;
            }
        }
        file_put_contents($envPath, $envContent);
    }
}
