<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\UltaVpnApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CustomerRenewController extends Controller
{
    protected function findPlan(string $planId, UltaVpnApi $api): ?array
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

        $plans = $api->getPlans();
        return collect($plans)->firstWhere('id', $planId);
    }

    public function index($planId, UltaVpnApi $api)
    {
        $subscription = $api->getCustomerSubscription();
        $plan = $this->findPlan($planId, $api);

        if (!$plan) {
            return redirect()->route('customer.dashboard')->with('error', 'Plan not found.');
        }

        return view('customer.renew', [
            'plan' => $plan,
            'currentSubscription' => $subscription,
            'stripeKey' => config('ultavpn.stripe_key'),
            'paypalClientId' => config('ultavpn.paypal_client_id'),
        ]);
    }

    public function createStripeIntent(Request $request, $planId, UltaVpnApi $api)
    {
        $plan = $this->findPlan($planId, $api);
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

    public function process(Request $request, $planId, UltaVpnApi $api)
    {
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $plan = $this->findPlan($planId, $api);
        if (!$plan) {
            return response()->json(['success' => false, 'error' => 'Plan not found.'], 404);
        }

        $user = Session::get('ultavpn_user');
        $customerId = $user['id'] ?? null;

        if (!$customerId) {
            return response()->json(['success' => false, 'error' => 'Not authenticated.'], 401);
        }

        try {
            $result = $api->renewSubscription($customerId, $planId);
            return response()->json([
                'success' => true,
                'subscription' => $result['subscription'] ?? null,
                'plan' => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
