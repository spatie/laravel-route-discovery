<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\NestedWithParametersController\Photos;

use Spatie\RouteDiscovery\Tests\TestClasses\Models\Comment;

class CommentsController
{
    public function show(Comment $comment)
    {
    }

    public function edit(Comment $comment)
    {
    }
}
