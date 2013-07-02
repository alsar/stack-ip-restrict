<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Alsar\Stack\RandomResponseApplication;
use Symfony\Component\HttpFoundation\Request;

$app = new RandomResponseApplication(1, 100);

$app = (new Stack\Builder())
    ->push('Alsar\Stack\IpRestrict', ['127.0.0.1'])
    ->resolve($app);

$request = Request::createFromGlobals();

$response = $app->handle($request);
$response->send();

$app->terminate($request, $response);