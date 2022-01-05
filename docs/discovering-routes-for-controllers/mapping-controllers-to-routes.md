---
title: Mapping controllers to routes
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

## Adding a route name

By default, the package will automatically add route names for each route that is registered. For this we'll use the controller name and the method name. 

For a `NewsController` with a method `myMethod`, the route name will be `news.my-method`. If that controller in a sub namespace, for example `App\Http\Controllers\Nested\NewsController`, the route name will become `nested.news.my-method`.

You can customize the route name that will be added by adding a `Route` attribute and pass a string to the `name` argument.

For the controller below, the discovered route will have the name `special-name`.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;

class NewsController
{
    #[Route(name: 'special-name')]
    public function specialMethod() { /* ... */ }
}
```

## Adding middleware

You can apply middleware to a route by adding a `Route` attribute and pass a middleware class to the `middleware` argument.

```php
namespace App\Http\Controllers;

use Illuminate\Routing\Middleware\ValidateSignature;
use Spatie\RouteDiscovery\Attributes\Route;

class DownloadController
{
    #[Route(middleware: ValidateSignature::class)]
    public function download() { /* ... */ }
}
```

To apply a middleware on all methods of a controller, use the `Route` attribute at the class level. In the example below, the middleware will be applied on both the routes of both `download` and `otherMethod`.

```php
namespace App\Http\Controllers;

use Illuminate\Routing\Middleware\ValidateSignature;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: ValidateSignature::class)]
class DownloadController
{
    public function download() { /* ... */ }
    
    public function otherMethod() { /* ... */ }
}
```

Instead of a string, you can also pass an array with middleware to the `middleware` argument of the `Route` attribute.

```php
#[Route(middleware: [ValidateSignature::class, AnotherMiddleware::class])]
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

## Route parameter constraints

You can constraint the format of a route parameter by apply one of the `Where` attributes on a method or class.

In this following example this route will be registered: `/users/edit/{user}`. By adding the `WhereUuid` attribute, we make sure that only UUIDs will match the `{user}` parameter.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Attributes\WhereUuid;

class UsersController
{
    #[WhereUuid('user')]
    public function edit(User $user) { /* ... */ }
}
```

The package ships with these `Where` attributes:

- `Spatie\RouteDiscovery\Attributes\WhereAlpha`
- `Spatie\RouteDiscovery\Attributes\WhereAlphaNumeric`
- `Spatie\RouteDiscovery\Attributes\WhereNumeric`
- `Spatie\RouteDiscovery\Attributes\WhereUuid`

You can also specify your own regex, by using the `Where` attribute.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Attributes\Where;

class UsersController
{
    #[Where('user', constraint: '[0-9]+')]
    public function edit(User $user) { /* ... */ }
}
```

## Setting a domain

You can specify which domain the routes should be registered by passing a value to the `domain` parameter of the `Route` attribute. This can be done on both the class and method level.

Using this controller, the route to `firstMethod` will only listen for request to the `first.example.com` domain, the `secondMethod` to the `second.example.com` domain.

```php
namespace App\Http\Controllers;

use Illuminate\Routing\Middleware\ValidateSignature;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(domain: 'first.example.com')]
class ExampleController
{
    public function firstMethod() { /* ... */ }
    
    #[Route(domain: 'second.example.com')]
    public function secondMethod() { /* ... */ }
}
```

## Preventing routes from being discovered

You can prevent a certain controller from being discovered by using the `DoNotDiscover` attribute.

For this controller, only a route for the `anotherMethod` will be registered.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

class UsersController
{
    #[DoNotDiscover]
    public function myMethod() { /* ... */}
    
    public function anotherMethod() { /* ... */}
}
```

You can also prevent an entire controller from being discovered by adding the `DoNotDiscover` attribute on the class level. 

For this controller, not a single route will be registered.

```php
namespace App\Http\Controllers;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

#[DoNotDiscover]
class UsersController
{
    public function myMethod() { /* ... */}
    
    public function anotherMethod() { /* ... */}
}
```
