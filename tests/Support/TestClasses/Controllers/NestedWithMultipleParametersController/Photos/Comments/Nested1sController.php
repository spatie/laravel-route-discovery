<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithMultipleParametersController\Photos\Comments;

use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Comment;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Nested1;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;

class Nested1SController
{
    public function index(Photo $photo, Comment $comment)
    {

    }

    public function show(Photo $photo, Comment $comment, Nested1 $nested1)
    {

    }
}
