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

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 * This interface defines the middleware interface signature required by Relay.
 *
 * Implementing this is completely voluntary, it's mostly useful for indicating
 * that your class is middleware, and to ensure you type-hint the `__invoke()`
 * method signature correctly.
 *
 * @package Relay.Relay
 *
 */
interface MiddlewareInterface
{
    /**
     *
     * Middleware logic to be invoked.
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
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    );
}
