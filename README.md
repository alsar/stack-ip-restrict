# IpRestrict Stack middleware

[Stack](http://stackphp.com) middleware to restrict application access for specific IP addresses.

## Usage
### Silex example
```php
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
```

### Symfony example
```php
# web/app_dev.php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();

$stack = (new Stack\Builder())
    ->push('Alsar\Stack\IpRestrict', ['127.0.0.1', 'fe80::1', '::1']);

$kernel = $stack->resolve($kernel);

Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
```

## Intallation

The recommended way to install this library is through [Composer](http://getcomposer.org/):

``` json
{
    "require": {
        "alsar/stack-ip-restrict": "~1.0"
    }
}
```

## License

This library is released under the MIT License. See the bundled LICENSE file for details.