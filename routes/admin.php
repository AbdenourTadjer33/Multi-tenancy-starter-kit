<?php

use Inertia\Inertia;
use App\Enums\AdminType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $admin = $request->user('admin');

    if ($admin === AdminType::AppAdmin) {
        return redirect(route('admin.app'));
    }

    return redirect(route('admin.tenant.dashboard', ['tenant' => $admin->last_tenant_id ?? $admin->tenants()->first()->id]));
})->name('admin.index');

Route::prefix('/{tenant}')->as('admin.tenant.')->middleware([
    'auth:admin',
    // Stancl\Tenancy\Middleware\InitializeTenancyByPath::class,
    
    App\Http\Middleware\HandleAdminTenantRequests::class
])->group(function () {
    Route::get('/', function (Request $request) {
        return redirect(route('admin.tenant.dashboard', ['tenant' => $request->route('tenant')]));
    });

    Route::get('/dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
