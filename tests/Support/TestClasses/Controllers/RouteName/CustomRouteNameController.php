<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\RouteName;

use Spatie\RouteDiscovery\Attributes\Route;
use const Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteName\__METHOD__;

class CustomRouteNameController
{
    #[Route(name:'this-is-a-custom-name')]
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
