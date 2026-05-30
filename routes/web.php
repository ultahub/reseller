<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerRenewController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PlanController;

// Test endpoint (accessible anytime)
Route::post('/api/setup/test-connection', [SetupController::class, 'testConnection'])->name('setup.test-connection');

// Setup Routes (only accessible if setup is not completed)
Route::middleware('setup.not-completed')->group(function () {
    Route::get('/setup', [SetupController::class, 'show'])->name('setup.show');
    Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');
});

// Protected Routes (redirect to setup if not configured)
Route::middleware('check.setup')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('/checkout/{planId}', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/{planId}/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/{planId}/stripe-intent', [CheckoutController::class, 'createStripeIntent'])->name('checkout.stripe-intent');

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('reseller.auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/customers', [CustomerController::class, 'index'])->name('dashboard.customers');
            Route::get('/credits', [DashboardController::class, 'credits'])->name('dashboard.credits');
            Route::get('/gateways', [PaymentGatewayController::class, 'index'])->name('dashboard.gateways');
            Route::put('/gateways', [PaymentGatewayController::class, 'update'])->name('dashboard.gateways.update');
            Route::get('/plans', [PlanController::class, 'index'])->name('dashboard.plans');
            Route::get('/plans/create', [PlanController::class, 'create'])->name('dashboard.plans.create');
            Route::post('/plans', [PlanController::class, 'store'])->name('dashboard.plans.store');
            Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('dashboard.plans.edit');
            Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('dashboard.plans.update');
            Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('dashboard.plans.destroy');
            Route::get('/plans/{plan}/toggle', [PlanController::class, 'toggle'])->name('dashboard.plans.toggle');
        });
    });

    Route::middleware('customer.auth')->group(function () {
        Route::prefix('customer')->group(function () {
            Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
            Route::get('/billing', [BillingController::class, 'index'])->name('customer.billing');
            Route::get('/renew/{planId}', [CustomerRenewController::class, 'index'])->name('customer.renew');
            Route::post('/renew/{planId}/process', [CustomerRenewController::class, 'process'])->name('customer.renew.process');
            Route::post('/renew/{planId}/stripe-intent', [CustomerRenewController::class, 'createStripeIntent'])->name('customer.renew.stripe-intent');
            Route::get('/test', [TestController::class, 'index'])->name('customer.test');
        });
    });
});
