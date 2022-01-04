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

    protected function registerRouteForView(SplFileInfo $file, string $baseDirectory): void
    {
        $view = $this->determineView($file, $baseDirectory);
        $uri = $this->determineUri($file, $baseDirectory);
        $name = $this->determineName($file, $baseDirectory);

        Route::view($uri, $view)->name($name);
    }

    protected function determineView(SplFileInfo $file, string $baseDirectory): string
    {
        $uri = Str::of($file->getPathname())
            ->after($baseDirectory)
            ->beforeLast('.blade.php');

        return $uri->replace(DIRECTORY_SEPARATOR, '.');
    }

    protected function determineUri(SplFileInfo $file, string $baseDirectory): string
    {
        $uri = Str::of($file->getPathname())
            ->after($baseDirectory)
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
