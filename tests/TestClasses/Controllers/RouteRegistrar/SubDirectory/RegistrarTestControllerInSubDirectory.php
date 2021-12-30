<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory;

use Spatie\RouteDiscovery\Attributes\Get;

class RegistrarTestControllerInSubDirectory
{
    #[Get('in-sub-directory')]
    public function myMethod()
    {
    }
}
