<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultController;

class WelcomeController extends Controller
{
    public function index()
    {
        return 'I am a Welcome Controller.';
    }
}
