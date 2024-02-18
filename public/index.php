<?php

require_once '../vendor/autoload.php';

use App\App;
use Astrid\Events\ResponseEvent;
use Astrid\Listeners\ContentLengthListener;
use Astrid\Listeners\GoogleListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
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

$framework = new App($dispatcher,$matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();