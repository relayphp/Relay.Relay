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
     * @param callable|ResolverInterface $resolver Converts queue entries to
     * middleware callables.
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
     * @param Request $request The request.
     *
     * @param Response $response The response.
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
     * Calls the next entry in the queue; essentially an alias to `__invoke()`.
     *
     * @param Request $request The request.
     *
     * @param Response $response The response.
     *
     * @return Response
     *
     */
    public function run(Request $request, Response $response)
    {
        return $this($request, $response);
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
            return $this->last();
        }

        if (! $this->resolver) {
            return $entry;
        }

        return call_user_func($this->resolver, $entry);
    }

    /**
     *
     * Returns a new instance of the Last middleware callable.
     *
     * @return Last
     *
     */
    protected function last()
    {
        return new Last();
    }
}
