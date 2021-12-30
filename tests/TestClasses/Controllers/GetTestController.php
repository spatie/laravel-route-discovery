<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Get;

class GetTestController
{
    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }
}
