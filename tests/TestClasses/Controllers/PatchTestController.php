<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Patch;

class PatchTestController
{
    #[Patch('my-patch-method')]
    public function myPatchMethod()
    {
    }
}
