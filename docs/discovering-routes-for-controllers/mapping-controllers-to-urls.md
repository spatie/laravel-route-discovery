---
title: Mapping controllers to URLs
weight: 2
---

All the examples assume that you've registered to auto discover routes for all public methods of controller in the `app_path('Http/Controllers')` directory.

By default, the package will add a route using the name of both the controller and method.

For this controller, the `/news/my-method` route will be registered.

```php
namespace App\Http\Controllers;

class NewsController
{
    public function myMethod() { /* ... */ }
}
```

Of course, multiple methods in a controller will result in multiple routes being registered.

For this controller, `/news/my-method` and `/news/my-other-method` routes will be registered.

```php
namespace App\Http\Controllers;

class NewsController
{
    public function myMethod() { /* ... */ }
    public function myOtherMethod() { /* ... */ }
}
```

## Index methods

When a method is named `index`, the method name is not used when registering a route.

For this controller, the `/news` route will be registered.

```php
namespace App\Http\Controllers;

class NewsController
{
    public function index() { /* ... */ }
}
```

## Nested controllers

When a controller is in a sub-namespace, the sub-namespace names will be used when generating the URL.

For this controller, the `/nested/news` route will be registered.

```php
namespace App\Http\Controllers\Nested;

class NewsController
{
    public function index() { /* ... */ }
}
```

## Customizing the URL

You can override the last segment of the generated URL by using adding a `Route` attribute to your method and passing a value to the `uri` parameter.

For this controller, the `/news/alternative-uri` route will be registered instead of `/news/my-method`.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;

class NewsController
{
    #[Route(uri: 'alternative-uri')]
    public function myMethod() { /* ... */ }
}
```

If you want override the whole URL, pass a value to the `fullUri` method. 

For this controller, the `/alternative-uri` route will be registered instead of `/news/my-method`.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;

class NewsController
{
    #[Route(fullUri: 'alternative-uri')]
    public function myMethod() { /* ... */ }
}
```

## HTTP verbs

By default, all registered routes are `GET` routes.

There are a couple of method names that will result in another HTTP verb.

- `store`: `POST`
- `update`: `PUT` and  `PATCH`
- `destroy` and `delete`: `DELETE` 

You can customize the verb to be used by adding a `Route` attribute to a method

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;

class NewsController
{
    #[Route(method: 'post')]
    public function myMethod() { /* ... */ }
}
```

## Models as route parameters

A URL segment will be used for a parameter of a method that accepts an eloquent model.

For this controller, the `/users/edit/{user}` route will be registered.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;

class UsersController
{
    public function edit(User $user) { /* ... */ }
}
```

