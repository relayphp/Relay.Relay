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
 * A single-use PSR-7 middleware dispatcher.
 *
 * @package Relay.Relay
 *
 */
class Runner
{
    /**
     *
     * The middleware queue.
     *
     * @var (callable|MiddlewareInterface)[]
     *
     */
    protected $queue = [];

    /**
     *
     * A callable to convert queue entries to callables.
     *
     * @var callable|ResolverInterface
     *
     */
    protected $resolver;

    /**
     *
     * Constructor.
     *
     * @param (callable|MiddlewareInterface)[] $queue The middleware queue.
     *
     * @param callable|ResolverInterface $resolver Converts queue entries to callables.
     *
     */
    public function __construct(array $queue, callable $resolver = null)
    {
        $this->queue = $queue;
        $this->resolver = $resolver;
    }

    /**
     *
     * Calls the next entry in the queue.
     *
     * @param Request $request The incoming request.
     *
     * @param Response $response The outgoing response.
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response)
    {
        $entry = array_shift($this->queue);
        $middleware = $this->resolve($entry);
        return $middleware($request, $response, $this);
    }

    /**
     *
     * Converts a queue entry to a callable, using the resolver if present.
     *
     * @param mixed|callable|MiddlewareInterface $entry The queue entry.
     *
     * @return callable|MiddlewareInterface
     *
     */
    protected function resolve($entry)
    {
        if (! $entry) {
            // the default callable when the queue is empty
            return function (
                Request $request,
                Response $response,
                callable $next
            ) {
                return $response;
            };
        }

        if (! $this->resolver) {
            return $entry;
        }

        return call_user_func($this->resolver, $entry);
    }
}
