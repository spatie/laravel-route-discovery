<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Nesting;

class ParentController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
