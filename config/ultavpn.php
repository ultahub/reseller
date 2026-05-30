<?php

return [
    'api_url' => env('ULTAVPN_API_URL', 'https://ultavpn.com'),
    'api_key' => env('ULTAVPN_API_KEY', ''),
    'stripe_key' => env('STRIPE_KEY', ''),
    'stripe_secret' => env('STRIPE_SECRET', ''),
    'paypal_client_id' => env('PAYPAL_CLIENT_ID', ''),
    'paypal_client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
];
