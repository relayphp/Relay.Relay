<?php

namespace Relay;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function sprintf;

class FakeMiddleware implements MiddlewareInterface
{
    /** @var int */
    public static $count = 0;

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $n        = ++ static::$count;
        $response = $handler->handle($request);
        $response->getBody()->write(sprintf('<%s', $n));

        return $response;
    }
}
