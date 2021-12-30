<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Domain;
use Spatie\RouteDiscovery\Attributes\Get;
use Spatie\RouteDiscovery\Attributes\Post;

#[Domain('my-subdomain.localhost')]
class DomainTestController
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
