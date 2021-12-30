<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Options;

class OptionsTestController
{
    #[Options('my-options-method')]
    public function myOptionsMethod()
    {
    }
}
