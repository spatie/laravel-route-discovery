<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithMultipleParametersController;

use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;

class PhotosController
{
    public function show(Photo $photo)
    {
    }

    public function edit(Photo $photo)
    {
    }
}
