---
title: Getting started
weight: 1
---

This package can automatically discover and register routes for a directory containing controllers.

## Via the config file

In the `discover_controllers_in_directory` key of the `route-discovery` config file, you can specify a directory that contains controllers.

By default, all controllers in the `app_path('Http/Controllers')` will be registered.

```php
// config/route-discovery

/*
 * Routes will be registered for all controllers found in
 * these directories.
 */
'discover_controllers_in_directory' => [
    app_path('Http/Controllers'),
],

// ...
```

## Via the routes file

You can also enable route discovery via the routes file. If you want to go this... route 🥁, first remove all entries in the `discover_controllers_in_directory` key of the `route-discovery` config file.

```php
// in a routes file

use Spatie\RouteDiscovery\Discovery\Discover;

Discover::controllers()->in(app_path('Http/Controllers'));
```





