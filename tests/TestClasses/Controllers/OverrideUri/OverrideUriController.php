<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideUri;

use Spatie\RouteDiscovery\Attributes\Route;

class OverrideUriController
{
    #[Route(uri:'alternative-uri')]
    public function myMethod()
    {
        return $this::class . '@' . __METHOD__;
    }
}
