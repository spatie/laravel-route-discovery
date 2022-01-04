<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\OverrideFullUri;

use Spatie\RouteDiscovery\Attributes\Route;
use const Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideFullUri\__METHOD__;

class OverrideFullUriController
{
    #[Route(fullUri:'alternative-uri')]
    public function myMethod()
    {
        return $this::class . '@' . __METHOD__;
    }
}
