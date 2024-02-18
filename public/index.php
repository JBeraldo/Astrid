<?php

require_once '../vendor/autoload.php';

use App\Kernel;
use Astrid\Listeners\ContentLengthListener;
use Astrid\Listeners\GoogleListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\EventDispatcher\EventDispatcher;


$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/routes.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addListener('response', [new ContentLengthListener(), 'onResponse'], -255);
$dispatcher->addListener('response', [new GoogleListener(), 'onResponse']);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$kernel = new Kernel($dispatcher,$matcher, $controllerResolver, $argumentResolver);
$kernel = new HttpCache(
    $kernel,
    new Store(__DIR__.'/../cache')
);
$response = $kernel->handle($request);

$response->send();