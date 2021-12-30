<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;

class RoutePostTestController
{
    #[Route('post', 'my-post-method')]
    public function myPostMethod()
    {
    }
}
