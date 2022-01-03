<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideFullUri;

use Spatie\RouteDiscovery\Attributes\Route;

class OverrideFullUriController
{
    #[Route(fullUri:'alternative-uri')]
    public function myMethod()
    {
        return $this::class . '@' . __METHOD__;
    }
}
