<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithMultipleParametersController\Photos;

use Illuminate\Http\Request;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Comment;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\User;

class CommentsController
{
    public function index(Photo $photo)
    {
    }

    public function show(Photo $photo, Comment $comment)
    {
    }

    public function create(Photo $photo)
    {
    }

    public function store(Photo $photo, Request $request)
    {
    }

    public function edit(Photo $photo, Comment $comment)
    {
    }

    public function update(Photo $photo, Comment $comment, Request $request)
    {
    }

    public function destroy(Photo $photo, Comment $comment)
    {
    }
}
