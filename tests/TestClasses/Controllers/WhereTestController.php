<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Get;
use Spatie\RouteDiscovery\Attributes\Post;
use Spatie\RouteDiscovery\Attributes\Where;
use Spatie\RouteDiscovery\Attributes\WhereAlpha;
use Spatie\RouteDiscovery\Attributes\WhereAlphaNumeric;
use Spatie\RouteDiscovery\Attributes\WhereNumber;
use Spatie\RouteDiscovery\Attributes\WhereUuid;

#[Where('param', '[0-9]+')]
class WhereTestController
{
    #[Get('my-get-method/{param}')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method/{param}/{param2}')]
    #[Where('param2', '[a-zA-Z]+')]
    public function myPostMethod()
    {
    }

    #[Get('my-where-method/{param}/{param2}/{param3}')]
    #[Where('param2', '[a-zA-Z]+')]
    #[Where('param3', 'test')]
    public function myWhereMethod()
    {
    }

    #[Get('my-shorthands')]
    #[WhereAlpha('alpha')]
    #[WhereAlphaNumeric('alpha-numeric')]
    #[WhereNumber('number')]
    #[WhereUuid('uuid')]
    public function myShorthands()
    {
    }
}
