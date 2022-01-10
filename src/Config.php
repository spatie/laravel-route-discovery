<?php

namespace Spatie\RouteDiscovery;

use Spatie\RouteDiscovery\PendingRouteTransformers\AddControllerUriToActions;
use Spatie\RouteDiscovery\PendingRouteTransformers\AddDefaultRouteName;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleDomainAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleDoNotDiscoverAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleFullUriAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleHttpMethodsAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleMiddlewareAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleRouteNameAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleUriAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleUrisOfNestedControllers;
use Spatie\RouteDiscovery\PendingRouteTransformers\HandleWheresAttribute;
use Spatie\RouteDiscovery\PendingRouteTransformers\MoveRoutesStartingWithParametersLast;

class Config
{
    public static function defaultRouteTransformers(): array
    {
        return [
            HandleDoNotDiscoverAttribute::class,
            AddControllerUriToActions::class,
            HandleUrisOfNestedControllers::class,
            HandleRouteNameAttribute::class,
            HandleMiddlewareAttribute::class,
            HandleHttpMethodsAttribute::class,
            HandleUriAttribute::class,
            HandleFullUriAttribute::class,
            HandleWheresAttribute::class,
            AddDefaultRouteName::class,
            HandleDomainAttribute::class,
            MoveRoutesStartingWithParametersLast::class,
        ];
    }
}
