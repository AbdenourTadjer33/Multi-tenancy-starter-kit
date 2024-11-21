<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\AdminType;
use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        [$admin, $tenant] = DB::transaction(function () use ($request) {
            $admin = Admin::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'type' => AdminType::TenantAdmin,
            ]);

            $tenant = Tenant::query()->create([
                'company_name' => $request->input('company'),
            ]);

            $admin->tenants()->attach($tenant->id);

            $tenant->domains()->create([
                'domain' => generateUniqueSubdomain(),
            ]);

            return [$admin, $tenant];
        });

        event(new Registered($admin));

        Auth::guard('admin')->login($admin);

        return redirect(route('admin.tenant.dashboard', ['tenant' => $tenant->id]));
    }
}
