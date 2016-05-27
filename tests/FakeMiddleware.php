<?php
namespace Relay;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FakeMiddleware implements MiddlewareInterface
{
    public static $count = 0;

    public function __invoke(
        RequestInterface $request,
        callable $next
    ) {
        $response = $next($request);
        $response->getBody()->write(++ static::$count);
        return $response;
    }
}
