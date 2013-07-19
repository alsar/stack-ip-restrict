<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Alsar\Stack\RandomResponseApplication;

$app = new RandomResponseApplication(1, 100);
$appDev = new RandomResponseApplication(500, 600);

$appDev = (new Stack\Builder())
    ->push('Alsar\Stack\IpRestrict', ['127.0.0.1'])
    ->resolve($appDev);

$app = (new Stack\Builder())
    ->push('Stack\UrlMap', ['/dev' => $appDev])
    ->resolve($app);

$request = Request::createFromGlobals();

$response = $app->handle($request);
$response->send();

$app->terminate($request, $response);