---
title: Mapping views to routes
weight: 2
---

The package will add a route for each `blade.php` that it finds in [directory you've specified](getting-started).

Imagine you've configured view discovery this way.

```php
// config/route-discovery

'discover_views_in_directory' => [
    'docs' => resource_path('views/docs'),
],
```

And image that `views/docs` contains these Blade views...

- index.blade.php
- pageA.blade.php
- pageB.blade.php
- nested/index.blade.php
- nested/pageC.blade.php

... then these routes will be registered:

- /docs --> index.blade.php
- /docs/page-a --> pageA.blade.php
- /docs/page-b --> pageB.blade.php
- /docs/nested --> nested/index.blade.php
- /docs/nested/page-c --> nested/pageC.blade.php
