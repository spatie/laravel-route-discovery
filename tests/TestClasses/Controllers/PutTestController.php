<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Put;

class PutTestController
{
    #[Put('my-put-method')]
    public function myPutMethod()
    {
    }
}
