<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting;

class ParentController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
