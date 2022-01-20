---
title: Discovering routes for views
weight: 1
---

This package can automatically discover and register routes for a directory containing Blade views.

## Via the routes file

You can also enable route discovery via the routes file.

```php
// in a routes file

use Spatie\RouteDiscovery\Discovery\Discover;

Discover::views()->in(resource_path('views/auto'));
```

To use a prefix, add middleware, and more, you can put that call to `Discover::views()` in a group.

```php
// in a routes file

use Spatie\RouteDiscovery\Discovery\Discover;

Route::prefix('my-discovered-views')->group(function() {
    Discover::views()->in(resource_path('views/auto'));
});
```

## Via the config file

In the `discover_view_in_directory` key of the `route-discovery` config file, you can specify a directory that contains views.

```php
// config/route-discovery.php

// ...

/*
 * Routes will be registered for all views found in these directories.
 * The key of an item will be used as the prefix of the uri.
 */
'discover_views_in_directory' => [
    'docs' => resource_path('views/docs'),
],

// ..
```

Using this example above, routes will be registered for all views in the `resource_path('views/docs')` directory. The key of the item will be used as a prefix. If you don't want to prefix your discovered routes, simply do not use a key.

```php
// config/route-discovery.php

'discover_views_in_directory' => [
    resource_path('views/discovery'),
],
```

Of course, you can also discover routes for multiple directories in one go.

```php
// config/route-discovery.php

'discover_views_in_directory' => [
    resource_path('views/discovery'),
    resource_path('views/another-directory'),
],
```

If you want to register multiple directories with the same prefix, you can use array syntax

```php
// config/route-discovery.php

'discover_views_in_directory' => [
    'docs' => [
        resource_path('views/docs'), 
        resource_path('views/other-docs')
    ],
],
```


