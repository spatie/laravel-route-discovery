<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Post;

class PostTestController
{
    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
