<?php

namespace App\Http\Middleware;

use App\Http\Resources\AdminTenant\TenantResource;
use App\Http\Resources\AdminTenant\UserResource;
use Illuminate\Http\Request;

class HandleAdminTenantRequests extends HandleInertiaRequests
{
    /**
     * 
     * @var string
     */
    protected $rootView = "admin-tenant";

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => new UserResource($request->user('admin')),
            'tenant' => new TenantResource(tenancy()->query()->find($request->route('tenant'))),
        ]);
    }
}
