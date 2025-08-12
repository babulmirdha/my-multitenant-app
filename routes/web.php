<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// foreach (config('tenancy.central_domains') as $domain) {
//     Route::domain($domain)->group(function () {
//         Route::get('/', function () {
//             return 'Welcome to the central admin!';
//         });

//         Route::get('/tenants', [TenantController::class, 'index']);
//         Route::post('/tenants', [TenantController::class, 'store']);
//         Route::get('/billing', [BillingController::class, 'show']);
//     });
// }

// Admin central domain
Route::domain(config('app.env') === 'local' ? 'admin.localhost' : 'admin.myapp.com')
    ->group(function () {
        Route::get('/', fn() => 'Welcome to the Admin Dashboard!');
        Route::get('/tenants', [TenantController::class, 'index']);
        Route::post('/tenants', [TenantController::class, 'store']);
    });

// Billing central domain
Route::domain(config('app.env') === 'local' ? 'billing.localhost' : 'billing.myapp.com')
    ->group(function () {
        Route::get('/', fn() => 'Welcome to the Billing Portal!');
        Route::get('/billing', [BillingController::class, 'show']);
    });

// Plain localhost central domain
Route::domain('localhost')->group(function () {
    Route::get('/', fn() => 'Welcome to the Localhost Central Page!');
    Route::get('/info', fn() => phpinfo());
});
