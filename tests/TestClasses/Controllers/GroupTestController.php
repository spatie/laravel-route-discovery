<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Get;
use Spatie\RouteDiscovery\Attributes\Group;
use Spatie\RouteDiscovery\Attributes\Post;

#[Group(domain: 'my-subdomain.localhost', prefix: 'my-prefix')]
#[Group(domain: 'my-second-subdomain.localhost', prefix: 'my-second-prefix')]
class GroupTestController
{
    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
