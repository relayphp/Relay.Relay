<?php
namespace Relay;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class FakeMiddleware
{
    public static $count = 0;

    public function __invoke(Request $request, Response $response, callable $next)
    {
        $response->getBody()->write(++ static::$count);
        $response = $next($request, $response);
        $response->getBody()->write(++ static::$count);
        return $response;
    }
}