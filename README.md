# UltaVPN Reseller Panel

A white-label VPN reseller platform built with Laravel. Sell premium VPN services under your own brand with automated account delivery via the UltaVPN API.

## Features

- **Reseller Dashboard** — manage customers, credits, payment gateways, and VPN plans
- **Customer Portal** — subscription management, billing history, and self-renewal
- **Automated Delivery** — accounts created automatically after payment via UltaVPN API
- **Stripe & PayPal** — integrated payment processing
- **Responsive UI** — Tailwind CSS, mobile-friendly design

## Requirements

- PHP 8.2+
- Composer 2.x
- SQLite (included) or MySQL 5.7+
- Web server (Apache / Nginx)

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/ultavpn-reseller.git
cd ultavpn-reseller

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run database migrations
php artisan migrate

# 6. Seed default settings
php artisan db:seed --class=SetupSeeder

# 7. Start development server
php artisan serve
```

Visit `http://localhost:8000/setup` to configure your admin credentials and UltaVPN API key.

## Configuration

Key environment variables in `.env`:

| Variable | Description |
|----------|-------------|
| `APP_NAME` | Your brand name |
| `ULTAVPN_API_URL` | UltaVPN API base URL |
| `ULTAVPN_API_KEY` | Your UltaVPN API key |
| `STRIPE_KEY` | Stripe publishable key |
| `STRIPE_SECRET` | Stripe secret key |
| `PAYPAL_CLIENT_ID` | PayPal client ID |
| `PAYPAL_SECRET` | PayPal secret |

## Quick Start

After setup, access these URLs:

- **Landing Page** — `http://localhost:8000`
- **Reseller Login** — `http://localhost:8000/login`
- **Setup Wizard** — `http://localhost:8000/setup`

## API Documentation

For API documentation and integration details, contact **support@ultavpn.com** or visit **[https://ultavpn.com](https://ultavpn.com)**.

## Developer

**Ian Rey A. Torres**  
Philippines

## License

Proprietary software. All rights reserved.
