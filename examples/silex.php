<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Alsar\Stack\IpRestrict;

$app = new Silex\Application();

$app->get('/', function(Request $request) {
    return new Response('Hello world!', 200);
});

$app = (new Stack\Builder())
    ->push('Alsar\Stack\IpRestrict', ['127.0.0.1'])
    ->resolve($app)
;

$request = Request::createFromGlobals();
$response = $app->handle($request)->send();

$app->terminate($request, $response);
