<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Get;
use Spatie\RouteDiscovery\Attributes\Post;
use Spatie\RouteDiscovery\Attributes\Prefix;

#[Prefix('my-prefix')]
class PrefixTestController
{
    #[Get('/')]
    public function myRootGetMethod()
    {
    }

    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
