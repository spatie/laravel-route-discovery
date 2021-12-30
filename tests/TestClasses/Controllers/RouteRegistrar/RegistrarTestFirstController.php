<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteRegistrar;

use Spatie\RouteDiscovery\Attributes\Get;

class RegistrarTestFirstController
{
    #[Get('first-method')]
    public function myMethod()
    {
    }
}
