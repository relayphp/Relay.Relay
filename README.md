# Relay

A PSR-15 request handler.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/badges/quality-score.png?b=2.x)](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/?branch=2.x) [![Code Coverage](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/badges/coverage.png?b=2.x)](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/?branch=2.x) [![Build Status](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/badges/build.png?b=2.x)](https://scrutinizer-ci.com/g/relayphp/Relay.Relay/build-status/2.x)

This package is installable and PSR-4 autoloadable via Composer as `"relay/relay": "~2.0"`.

Alternatively, download a release or clone this repository, then map the `Relay\` namespace to the package `src/` directory.

This package requires PHP 7.0 or later. You should use the latest available version of PHP as a matter of principle.

To run the tests, issue `composer install` to install the test dependencies, then issue `phpunit`.

Please see <http://relayphp.com> for documentation.

## Request Handling

First, create an array or [traversable](http://php.net/traversable) `$queue` of middleware entries:

```php
$queue[] = new FooMiddleware();
$queue[] = new BarMiddleware();
$queue[] = new BazMiddleware();
// ...
$queue[] = new ResponseFactoryMiddleware {
    return new Response();
};
```

Then create a _Relay_ with the `$queue` and call the `handle()` method with a server request.

```php
/**
 * @var \Psr\Http\Message\RequestInterface $request
 * @var \Psr\Http\Message\ResponseInterface $response
 */

use Relay\Relay;

$relay = new Relay($queue);
$response = $relay->handle($request);
```

That will execute each of the middlewares in first-in-first-out order.

## Queue Entry Resolvers

You may wish to use `$queue` entries other than already-instantiated objects. If so, you can pass a `$resolver` callable to the _Relay_ that will convert the `$queue` entry to an instance. Thus, using a `$resolver` allows you to pass in your own factory mechanism for `$queue` entries.

For example, this `$resolver` will naively convert `$queue` string entries to new class instances:

```php
$resolver = function ($entry) {
    return new $entry();
};
```

You can then add `$queue` entries as class names, and the _Relay_ will use the `$resolver` to create the objects in turn.

```php
$queue[] = 'FooMiddleware';
$queue[] = 'BarMiddleware';
$queue[] = 'BazMiddleware';
$queue[] = 'ResponseFactoryMiddleware';

$relay = new Relay($queue, $resolver);
```

## Callable Middleware

_Relay_ can also handle any middleware entries that are callables with the following signature:

```php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

function (
    Request $request, // the request
    callable $next // the next middleware or handler
) : Response {
    // ...
}
```

Callable middleware may be intermingled with PSR-15 middleware.

[RequestHandlerInterface]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-15-request-handlers.md#21-psrhttpserverrequesthandlerinterface
[MiddlewareInterface]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-15-request-handlers.md#22-psrhttpservermiddlewareinterface
