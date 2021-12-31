<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\SingleController;

class MyController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
