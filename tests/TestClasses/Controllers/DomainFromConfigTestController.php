<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\DomainFromConfig;
use Spatie\RouteDiscovery\Attributes\Get;
use Spatie\RouteDiscovery\Attributes\Post;

#[DomainFromConfig('domains.test')]
class DomainFromConfigTestController
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
