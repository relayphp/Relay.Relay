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
use UnexpectedValueException;

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
     * A callable used as the last middleware callable.
     *
     * @var callable|null
     *
     */
    protected $next;

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
     * @param ServerRequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     * 
     * @param callable|null $next An optional callable used to run this instance as a middleware callable.
     *
     * @return ResponseInterface
     *
     * @throws \UnexpectedValueException Middleware must return instance of ResponseInterface.
     *
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $this->next = $next;

        return $this->run($request, $response);
    }

    /**
     *
     * Calls the next entry in the queue; essentially an alias to `__invoke()`.
     *
     * @param ServerRequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @return ResponseInterface
     *
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        $entry = array_shift($this->queue);
        $middleware = $this->resolve($entry);

        $return = $middleware($request, $response, [$this, 'run']);

        if(! $return instanceof ResponseInterface) {
            throw new UnexpectedValueException("Middleware must return Response object.");
        }

        return $return;
    }

    /**
     *
     * Converts a queue entry to a callable, using the resolver if present.
     *
     * @param mixed $entry The queue entry.
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
     * @return Last|callable
     *
     */
    protected function last()
    {
        return $this->next ?: new Last();
    }
}
