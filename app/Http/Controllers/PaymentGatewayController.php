<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        // Fetch settings from database
        $settings = [
            'stripe' => [
                'public_key' => Setting::where('key', 'STRIPE_KEY')->value('value'),
                'secret_key' => Setting::where('key', 'STRIPE_SECRET')->value('value'),
            ],
            'paypal' => [
                'client_id' => Setting::where('key', 'PAYPAL_CLIENT_ID')->value('value'),
                'secret' => Setting::where('key', 'PAYPAL_CLIENT_SECRET')->value('value'),
            ],
        ];

        return view('dashboard.gateways', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'stripe_public_key' => ['nullable', 'string'],
            'stripe_secret_key' => ['nullable', 'string'],
            'paypal_client_id' => ['nullable', 'string'],
            'paypal_secret' => ['nullable', 'string'],
        ]);

        try {
            $settingsToUpdate = [
                'STRIPE_KEY' => $validated['stripe_public_key'] ?? null,
                'STRIPE_SECRET' => $validated['stripe_secret_key'] ?? null,
                'PAYPAL_CLIENT_ID' => $validated['paypal_client_id'] ?? null,
                'PAYPAL_CLIENT_SECRET' => $validated['paypal_secret'] ?? null,
            ];

            foreach ($settingsToUpdate as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

            return back()->with('success', 'Payment gateway settings updated successfully!');
        } catch (\Exception $e) {
            Log::error('Payment gateway update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }
}
