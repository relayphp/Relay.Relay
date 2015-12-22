<?php
namespace Relay;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class FakeMiddleware implements MiddlewareInterface
{
    public static $count = 0;

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        $response->getBody()->write(++ static::$count);
        $response = $next($request, $response);
        $response->getBody()->write(++ static::$count);
        return $response;
    }
}
