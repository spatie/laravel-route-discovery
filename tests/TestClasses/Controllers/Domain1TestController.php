<?php

declare(strict_types=1);

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\DomainFromConfig;
use Spatie\RouteDiscovery\Attributes\Get;

#[DomainFromConfig('domains.test')]
class Domain1TestController
{
    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }
}
