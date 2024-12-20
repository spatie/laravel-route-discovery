<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithMultipleParametersController\Photos;

use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Comment;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\User;

class CommentsController
{
    public function show(Photo $photo, Comment $comment)
    {
    }

    public function edit(Photo $photo, Comment $comment)
    {
    }

    public function store(Photo $photo, Comment $comment)
    {
    }
}
