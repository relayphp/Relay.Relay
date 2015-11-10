<?php
/**
 *
 * This file is part of Relay for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2015, Paul M. Jones
 *
 */
namespace Relay;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 * Formally defines the middleware interface signature required by Relay.
 *
 * Implementing this is completely voluntary. It is useful for indicating that
 * a class is intended for use as middleware, and to ensure the `__invoke()`
 * method is typehinted correctly.
 *
 * @package Relay.Relay
 *
 */
interface MiddlewareInterface
{
    /**
     *
     * Invokes the middleware.
     *
     * @param RequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @param callable|MiddlewareInterface $next The next middleware.
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next
    );
}
