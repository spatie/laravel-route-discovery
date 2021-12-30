<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteRegistrar;

use Spatie\RouteDiscovery\Attributes\Get;

class RegistrarTestSecondController
{
    #[Get('second-method')]
    public function myMethod()
    {
    }
}
