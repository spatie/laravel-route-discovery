---
title: Using route transformers
weight: 1
---

Under the hood, the package will build up a collection of `Spatie\RouteDiscovery\PendingRoutes\PendingRoute` instances by looking at the controllers and views in your project. This collection of `PendingRoutes` can be modified by a `PendingRouteTransformer`. After that, each `action` inside a `PendingRoute` will be registered as a regular Laravel route.

In the `route-discovery` config file you'll see the registered route transformers.

```php
// in config/route-discovery.php

/*
 * After having discovered all controllers, these classes will manipulate the routes
 * before registering them to Laravel.
 *
 * In most cases, you shouldn't change these.
 */
'pending_route_transformers' => [
    ...Spatie\RouteDiscovery\Config::defaultRouteTransformers(),
    //
],
```

This is the returned value of `Spatie\RouteDiscovery\Config::defaultRouteTransformers()`:

```php
[
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleDoNotDiscoverAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\AddControllerUriToActions::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleUrisOfNestedControllers::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleRouteNameAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleMiddlewareAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleHttpMethodsAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleUriAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleFullUriAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleWheresAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\AddDefaultRouteName::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\HandleDomainAttribute::class,
    Spatie\RouteDiscovery\PendingRouteTransformers\MoveRoutesStartingWithParametersLast::class,
];
```

These transformers will handle specific `Route` attributes, make sure the routes are registered in the correct orders, ... 

## Creating your own route transformer

You can create your own route transformer by letting a class implement the `Spatie\RouteDiscovery\PendingRouteTransformers\PendingRouteTransformer` interface. Here's how that interface looks like:

```php
use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;

interface PendingRouteTransformer
{
    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection;
}
```

After you've created your transformer, register it in the `pending_route_transformers` key of the `route-discovery` config file.

Take a look at one of the default route transformers for an example implementation.
