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

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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
     * @param Request $request The request.
     *
     * @param Response $response The response.
     *
     * @param callable|MiddlewareInterface $next The next middleware.
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response, callable $next);
}
