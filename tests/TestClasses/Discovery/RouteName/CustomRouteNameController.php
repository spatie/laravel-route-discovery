<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\RouteName;

use Spatie\RouteDiscovery\Attributes\Route;

class CustomRouteNameController
{
    #[Route(name:'this-is-a-custom-name')]
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
