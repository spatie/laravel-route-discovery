<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Any;

class AnyTestController
{
    #[Any('my-any-method')]
    public function myAnyMethod()
    {
    }
}
