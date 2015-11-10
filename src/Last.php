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
     * @param Request $request The request.
     *
     * @param Response $response The response.
     *
     * @param callable|MiddlewareInterface $next The next middleware (which will
     * not be called).
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        return $response;
    }
}
