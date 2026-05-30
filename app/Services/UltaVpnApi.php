<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UltaVpnApi
{
    protected string $baseUrl;
    protected ?string $token = null;
    protected ?string $apiKey = null;

    public function __construct()
    {
        $apiUrl = config('ultavpn.api_url');
        $apiKey = config('ultavpn.api_key');
        
        try {
            $dbUrl = \App\Models\Setting::where('key', 'ULTAVPN_API_URL')->value('value');
            $dbKey = \App\Models\Setting::where('key', 'ULTAVPN_API_KEY')->value('value');
            $this->baseUrl = $dbUrl ? rtrim($dbUrl, '/') : $apiUrl;
            $this->apiKey = $dbKey ?: $apiKey;
        } catch (\Exception $e) {
            $this->baseUrl = $apiUrl;
            $this->apiKey = $apiKey;
        }
        
        $this->token = Session::get('ultavpn_token');
    }

    protected function headers(): array
    {
        $h = ['Accept' => 'application/json'];
        if ($this->token) {
            $h['Authorization'] = 'Bearer ' . $this->token;
        } else {
            $apiKey = $this->apiKey ?: config('ultavpn.api_key');
            if ($apiKey) {
                $h['Authorization'] = 'Bearer ' . $apiKey;
            }
        }
        return $h;
    }

    protected function apiKeyHeaders(): array
    {
        $apiKey = $this->apiKey ?: config('ultavpn.api_key');
        return ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $apiKey];
    }

    public function login(string $email, string $password): ?array
    {
        $res = Http::post("{$this->baseUrl}/api/auth/login", [
            'email' => $email,
            'password' => $password,
        ]);
        if ($res->successful()) {
            $data = $res->json();
            return $data['data'] ?? null;
        }
        return null;
    }

    public function getPlans(): array
    {
        $res = Http::get("{$this->baseUrl}/api/plans");
        return $res->successful() ? ($res->json()['data'] ?? []) : [];
    }

    public function getResellerPlans(): array
    {
        $res = Http::withHeaders($this->apiKeyHeaders())
            ->get("{$this->baseUrl}/api/v1/reseller/plans");
        return $res->successful() ? ($res->json()['data'] ?? []) : [];
    }

    public function getCredits(): float
    {
        $res = Http::withHeaders($this->apiKeyHeaders())
            ->get("{$this->baseUrl}/api/v1/reseller/credits");
        return $res->successful() ? (float)($res->json()['data']['credits'] ?? 0) : 0;
    }

    public function getCustomers(): array
    {
        $res = Http::withHeaders($this->apiKeyHeaders())
            ->get("{$this->baseUrl}/api/v1/reseller/customers");
        return $res->successful() ? ($res->json()['data'] ?? []) : [];
    }

    public function createCustomer(array $data): ?array
    {
        $res = Http::withHeaders($this->apiKeyHeaders())
            ->post("{$this->baseUrl}/api/v1/reseller/customers", $data);
        if ($res->successful()) {
            return $res->json()['data'] ?? null;
        }
        $body = $res->json();
        throw new \Exception($body['error'] ?? $body['message'] ?? 'Failed to create customer');
    }

    public function getCustomerSubscription(): ?array
    {
        if (!$this->token) return null;
        $res = Http::withHeaders(['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token])
            ->get("{$this->baseUrl}/api/customer/subscription");
        if (!$res->successful()) return null;
        $data = $res->json();
        // Wrapped in { subscription: {...}, plans: null }
        return $data['data']['subscription'] ?? $data['data'] ?? null;
    }

    public function renewSubscription(string $customerId, string $planId): ?array
    {
        $res = Http::withHeaders($this->apiKeyHeaders())
            ->post("{$this->baseUrl}/api/v1/reseller/renew", [
                'customerId' => $customerId,
                'planId' => $planId,
            ]);
        if ($res->successful()) {
            return $res->json()['data'] ?? null;
        }
        $body = $res->json();
        throw new \Exception($body['error'] ?? $body['message'] ?? 'Failed to renew subscription');
    }
}
