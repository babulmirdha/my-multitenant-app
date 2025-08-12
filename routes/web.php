<?php

use Illuminate\Support\Facades\Route;

/*

Option 1: foreach + if conditions ✅
Pros:

All central-domain logic is in one place.

Easy to add/remove domains by only editing config('tenancy.central_domains').

Keeps routes/web.php DRY if you have many domains.

Cons:

if/elseif blocks can get messy if you have lots of domain-specific logic.

Slightly harder to read for someone new to the code — they have to mentally connect config('tenancy.central_domains') with the routes.

 */

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () use ($domain) {

        // Admin central domain
        if (in_array($domain, ['admin.myapp.com', 'admin.localhost'])) {
            Route::get('/', fn() => 'Welcome to the Admin Dashboard!');
            Route::get('/tenants', [TenantController::class, 'index']);
            Route::post('/tenants', [TenantController::class, 'store']);
        }

        // Billing central domain
        elseif (in_array($domain, ['billing.myapp.com', 'billing.localhost'])) {
            Route::get('/', fn() => 'Welcome to the Billing Portal!');
            Route::get('/billing', [BillingController::class, 'show']);
        }

        // Plain localhost central domain
        elseif (in_array($domain, ['localhost', '127.0.0.1'])) {
            Route::get('/', fn() => 'Welcome to the Localhost Central Page!');
            Route::get('/info', fn() => phpinfo());
        }
    });
}

// or below code: borth are same

/*

Option 2: Explicit Route::domain() per domain ✅
Pros:

Very clear — you see exactly what routes belong to each domain without reading conditions.

Easier for newcomers to follow.

No hidden dependency on config('tenancy.central_domains').

Cons:

More repetition — you have to manually add domain names in both config and routes.

If you add a new central domain, you must remember to also add a new Route::domain() block.

📌 My Recommendation
If you expect only 2–3 central domains, I’d use Option 2 for clarity.
If you expect to grow and have many central domains (or they might change often), I’d use Option 1 for maintainability.

*/

// Admin central domain
// Route::domain(config('app.env') === 'local' ? 'admin.localhost' : 'admin.myapp.com')
//     ->group(function () {
//         Route::get('/', fn() => 'Welcome to the Admin Dashboard!');
//         Route::get('/tenants', [TenantController::class, 'index']);
//         Route::post('/tenants', [TenantController::class, 'store']);
//     });

// // Billing central domain
// Route::domain(config('app.env') === 'local' ? 'billing.localhost' : 'billing.myapp.com')
//     ->group(function () {
//         Route::get('/', fn() => 'Welcome to the Billing Portal!');
//         Route::get('/billing', [BillingController::class, 'show']);
//     });

// // Plain localhost central domain
// Route::domain('localhost')->group(function () {
//     Route::get('/', fn() => 'Welcome to the Localhost Central Page!');
//     Route::get('/info', fn() => phpinfo());
// });
