<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\AdminType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Authentication\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        $request->session()->regenerate();

        $admin = $request->user('admin');

        if ($admin->type === AdminType::AppAdmin) {
            return redirect()->intended(route('admin.'));
        }

        return redirect()->intended(route('admin.tenant.dashboard', ['tenant' => $admin->last_tenant_id ?? $admin->tenants()->first()->id]));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
