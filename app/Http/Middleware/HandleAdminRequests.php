<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class HandleAdminRequests extends HandleInertiaRequests
{
    /** 
     * 
     * @var string
     */
    protected $rootView = "admin";

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // 
        ]);
    }
}
