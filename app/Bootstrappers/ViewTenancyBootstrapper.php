<?php

namespace App\Bootstrappers;

use Illuminate\Support\Facades\View;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class ViewTenancyBootstrapper implements TenancyBootstrapper
{
    /** @var array Original view paths */
    protected $originalViewPaths;

    public function __construct()
    {
        $this->originalViewPaths = View::getFinder()->getPaths();
    }

    public function bootstrap(Tenant $tenant)
    {
        $viewPath = storage_path('resources/views');

        if (!in_array($viewPath, View::getFinder()->getPaths())) {
            View::getFinder()->addLocation($viewPath);
        }
    }

    public function revert()
    {
        View::getFinder()->setPaths($this->originalViewPaths);
    }
}
