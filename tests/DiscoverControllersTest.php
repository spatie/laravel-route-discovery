<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteDiscovery\Discovery\Discover;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\CustomMethod\CustomMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultController\WelcomeController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Single\MyController;

it('can discover controller in a directory', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('Single'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my',
        );
});

it('does not discover routes on default and abstract controller', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('DefaultController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            WelcomeController::class,
            controllerMethod: 'index',
            uri: 'welcome',
        );
});

it('can discover controllers with custom methods', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('CustomMethod'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            CustomMethodController::class,
            controllerMethod: 'myCustomMethod',
            uri: 'custom-method/my-custom-method'
        );
});

it('can use a prefix when discovering routes', function () {
    Route::prefix('my-prefix')->group(function () {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
            ->useBasePath(test()->getTestPath())
            ->in(controllersPath('Single'));
    });

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my-prefix/my',
        );
});
