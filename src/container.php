<?php

use App\App\Kernel;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$container = new DependencyInjection\ContainerBuilder();
$container->register('context', Routing\RequestContext::class);

$container->register('array_cache', \Symfony\Component\Cache\Adapter\PhpArrayAdapter::class)
    ->setArguments([ __DIR__.'/../cache/route.cache', new \Symfony\Component\Cache\Adapter\FilesystemAdapter()]);

$container->register('matcher', Routing\Matcher\CompiledUrlMatcher::class)
    ->setArguments([\Astrid\Facades\RouteCache::get(), new Reference('context')]);

$container->register('request_stack', HttpFoundation\RequestStack::class);
$container->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$container->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$container->register('listener.router', HttpKernel\EventListener\RouterListener::class)
    ->setArguments([new Reference('matcher'), new Reference('request_stack')])
;
$container->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(['UTF-8'])
;
$container->register('listener.exception', HttpKernel\EventListener\ErrorListener::class)
    ->setArguments([[\Astrid\Controllers\ErrorController::class,'exception']])
;
$container->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')])
;
$container->register('kernel', Kernel::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ])
;

return $container;