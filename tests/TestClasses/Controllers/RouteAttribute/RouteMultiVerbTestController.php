<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;

class RouteMultiVerbTestController
{
    #[Route(['get', 'post', 'delete'], 'my-multi-verb-method')]
    public function myMultiVerbMethod()
    {
    }
}
