<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DeleteTestController;

it('can register a delete route', function () {
    $this->oldRouteRegistrar->registerClass(DeleteTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
});
