<?php

namespace Spatie\RouteDiscovery\Tests;

use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

test('the new registrar works', function () {
    $this
        ->newRouteRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        MyController::class,
        controllerMethod: 'index',
        uri: 'my',
    );
});
