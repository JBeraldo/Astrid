<?php

namespace Astrid\Providers;

use Astrid\Facades\RouteCache;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;

class RouteProvider
{
    public function __construct()
    {
    }

    public static function generate(): array
    {
        $route_collection = include __DIR__.'/../../src/routes.php';

        return (new CompiledUrlMatcherDumper($route_collection))->getCompiledRoutes();
    }

    public static function provide(): array
    {
        return RouteCache::get();
    }
}