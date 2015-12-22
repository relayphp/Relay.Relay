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
 * Used as the last middleware when the queue is empty.
 *
 * @package Relay.Relay
 *
 */
class Last implements MiddlewareInterface
{
    /**
     *
     * Bounces the Response back through the middleware queue.
     *
     * @param ServerRequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @param callable|MiddlewareInterface $next The next middleware (which will
     * not be called).
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        return $response;
    }
}
