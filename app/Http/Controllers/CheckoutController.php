<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\UltaVpnApi;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    protected UltaVpnApi $api;

    public function __construct(UltaVpnApi $api)
    {
        $this->api = $api;
    }

    protected function findPlan(string $planId): ?array
    {
        $localPlan = Plan::find($planId);
        if ($localPlan && $localPlan->is_active) {
            return [
                'id' => (string) $localPlan->id,
                'name' => $localPlan->name,
                'durationDays' => $localPlan->duration_days,
                'bandwidthGb' => $localPlan->bandwidth_gb,
                'deviceLimit' => $localPlan->device_limit,
                'price' => (float) $localPlan->price,
            ];
        }

        $plans = $this->api->getPlans();
        return collect($plans)->firstWhere('id', $planId);
    }

    public function index($planId)
    {
        $plan = $this->findPlan($planId);
        if (!$plan) {
            return redirect()->route('pricing')->with('error', 'Plan not found.');
        }
        return view('checkout', [
            'plan' => $plan,
            'stripeKey' => config('ultavpn.stripe_key'),
            'paypalClientId' => config('ultavpn.paypal_client_id'),
        ]);
    }

    public function createStripeIntent(Request $request, $planId)
    {
        $plan = $this->findPlan($planId);
        if (!$plan) {
            return response()->json(['error' => 'Plan not found'], 404);
        }

        Stripe::setApiKey(config('ultavpn.stripe_secret'));

        $intent = PaymentIntent::create([
            'amount' => (int)($plan['price'] * 100),
            'currency' => 'usd',
            'metadata' => ['plan_id' => $planId],
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function process(Request $request, $planId)
    {
        $request->validate([
            'email' => 'required|email',
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $plan = $this->findPlan($planId);
        if (!$plan) {
            return response()->json(['success' => false, 'error' => 'Plan not found.'], 404);
        }

        $email = $request->email;
        $username = strstr($email, '@', true) ?: explode('@', $email)[0];
        $password = bin2hex(random_bytes(6));

        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'planId' => $planId,
        ];

        try {
            $result = $this->api->createCustomer($data);
            return response()->json([
                'success' => true,
                'customer' => [
                    'username' => $result['customer']['username'] ?? $username,
                    'password' => $password,
                    'email' => $email,
                ],
                'plan' => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
