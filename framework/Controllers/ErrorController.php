<?php
namespace Astrid\Controllers;

use Astrid\Facades\RouteCache;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorController
{
    public function exception(FlattenException $exception): Response
    {
        $msg = 'Something went wrong! ('.$exception->getMessage().')';


        if($exception->getStatusCode() === 404){
            RouteCache::clear();
        }

        return new Response($msg, $exception->getStatusCode());
    }
}