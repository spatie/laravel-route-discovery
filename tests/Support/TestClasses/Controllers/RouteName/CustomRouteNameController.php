<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\RouteName;

use Spatie\RouteDiscovery\Attributes\Route;

class CustomRouteNameController
{
    #[Route(name:'this-is-a-custom-name')]
    public function index()
    {

    }
}
