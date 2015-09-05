<?php

namespace Relay;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * This interface defines the middleware interface signature required by Relay.
 *
 * Implementing this is completely voluntary, it's mostly useful for indicating that
 * your class is middleware, and to ensure you type-hint the `__invoke()` method
 * signature correctly.
 */
interface MiddlewareInterface
{
    /**
     * @param Request                           $request  the request
     * @param Response                          $response the response
     * @param callable|MiddlewareInterface|null $next     the next middleware
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next = null);
}
