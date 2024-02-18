<?php

namespace Astrid\Facades;

use Astrid\Providers\RouteProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class RouteCache
{

    static function get():array
    {

        $cache = new PhpArrayAdapter(
            __DIR__.'/../../cache/route.cache',new FilesystemAdapter()
        );

        return $cache->get('routes', function (ItemInterface $item)  {
            $compiled_routes = RouteProvider::generate();

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