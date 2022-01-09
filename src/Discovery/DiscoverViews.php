<?php

namespace Spatie\RouteDiscovery\Discovery;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class DiscoverViews
{
    public function in(string $directory): void
    {
        $files = (new Finder())->files()->name('*.blade.php')->in($directory);

        collect($files)->each(function (SplFileInfo $file) use ($directory) {
            $this->registerRouteForView($file, $directory);
        });
    }

    protected function registerRouteForView(SplFileInfo $file, string $directory): void
    {
        $view = $this->determineView($file, $directory);
        $uri = $this->determineUri($file, $directory);
        $name = $this->determineName($file, $directory);

        Route::view($uri, $view)->name($name);
    }

    protected function determineView(SplFileInfo $file, string $directory): string
    {
        $viewPath = Str::of($file->getPathname())
            ->after(resource_path('views'))
            ->beforeLast('.blade.php')
            ->ltrim('/');

        return $viewPath->replace(DIRECTORY_SEPARATOR, '.');
    }

    protected function determineUri(SplFileInfo $file, string $directory): string
    {
        $uri = Str::of($file->getPathname())
            ->after($directory)
            ->beforeLast('.blade.php');

        $uri = Str::replaceLast(DIRECTORY_SEPARATOR . 'index', DIRECTORY_SEPARATOR, (string)$uri);

        return collect(explode(DIRECTORY_SEPARATOR, $uri))
            ->map(function (string $uriSegment) {
                return Str::kebab($uriSegment);
            })
            ->join('/');
    }

    protected function determineName(SplFileInfo $file, string $baseDirectory): string
    {
        $uri = $this->determineUri($file, $baseDirectory);

        if ($uri === '/') {
            return 'home';
        }

        return Str::of($this->determineUri($file, $baseDirectory))
            ->after('/')
            ->replace('/', '.')
            ->rtrim('.');
    }
}
