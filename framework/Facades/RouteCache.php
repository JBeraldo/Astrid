<?php

namespace Astrid\Facades;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Contracts\Cache\ItemInterface;

class RouteCache
{
    static function get():array
    {
        $cache = new PhpArrayAdapter(
            __DIR__.'/../../cache/route.cache',new FilesystemAdapter()
        );

        return $cache->get('routes', function (ItemInterface $item) {
            $route_collection = include __DIR__.'/../../src/routes.php';

            $compiled_routes = (new CompiledUrlMatcherDumper($route_collection))->getCompiledRoutes();

            $item->set($compiled_routes);

            return $compiled_routes;
        });
    }

    static function clear(): void
    {
        $cache = new PhpArrayAdapter(
            __DIR__.'/../../cache/route.cache',new FilesystemAdapter()
        );

        $cache->delete('routes');
    }
}