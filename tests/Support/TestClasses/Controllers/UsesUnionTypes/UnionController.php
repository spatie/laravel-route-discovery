<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\UsesUnionTypes;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UnionController
{
    public function example(Redirector|RedirectResponse $example): Redirector|RedirectResponse
    {
        return $example;
    }
}
