<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Alsar\Stack\RandomResponseApplication;

$app = new RandomResponseApplication(1, 100);
$appDev = new RandomResponseApplication(500, 600);

$stackDev = new Stack\Builder();
$stackDev
    ->push('Alsar\Stack\IpRestrict', array('127.0.0.1'))
    ->resolve($appDev);

$stack = new Stack\Builder();
$stack
    ->push('Stack\UrlMap', array('/dev' => $appDev))
    ->resolve($app);

$request = Request::createFromGlobals();

$response = $app->handle($request);
$response->send();

$app->terminate($request, $response);