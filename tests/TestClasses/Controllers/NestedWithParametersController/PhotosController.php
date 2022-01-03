<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\NestedWithParametersController;

use Spatie\RouteDiscovery\Tests\TestClasses\Models\Photo;

class PhotosController
{
    public function show(Photo $photo)
    {
    }

    public function edit(Photo $photo)
    {
    }
}
