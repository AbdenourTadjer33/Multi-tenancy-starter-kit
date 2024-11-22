<?php

namespace App\Enums;

enum AdminType: string
{
    case TenantAdmin = "tenant";
    case AppAdmin = "app";
}
