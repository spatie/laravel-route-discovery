<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Single;

class MyController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
