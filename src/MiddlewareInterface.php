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
     * @param RequestInterface  $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @param callable $next delegate function to dispatch the next middleware component:
     *                       function (RequestInterface $request, ResponseInterface $response): ResponseInterface
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    );
}
