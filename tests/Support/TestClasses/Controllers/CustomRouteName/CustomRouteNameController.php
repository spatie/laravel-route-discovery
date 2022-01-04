<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\CustomRouteName;

use Spatie\RouteDiscovery\Attributes\Route;

class CustomRouteNameController
{
    #[Route(name:'this-is-a-custom-name')]
    public function index()
    {

    }
}
