<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Delete;

class DeleteTestController
{
    #[Delete('my-delete-method')]
    public function myDeleteMethod()
    {
    }
}
