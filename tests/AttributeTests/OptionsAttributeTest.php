<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OptionsTestController;

it('can register a options route', function () {
    $this->oldRouteRegistrar->registerClass(OptionsTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(OptionsTestController::class, 'myOptionsMethod', 'options', 'my-options-method');
});
