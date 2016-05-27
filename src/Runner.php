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
use RuntimeException;

/**
 *
 * A single-use PSR-7 middleware dispatcher.
 *
 * @package relay/relay
 *
 */
class Runner implements RunnerInterface
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
     * callables.
     *
     */
    public function __construct(array $queue, callable $resolver = null)
    {
        $this->queue = $queue;
        $this->resolver = $resolver;
    }

    /**
     *
     * Runs the next entry in the queue.
     *
     * @param RequestInterface $request The request.
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(RequestInterface $request)
    {
        $entry = array_shift($this->queue);
        $middleware = $this->resolve($entry);
        return $middleware($request, $this);
    }

    /**
     *
     * Calls the next entry in the queue; essentially an alias to `__invoke()`.
     *
     * @param RequestInterface $request The request.
     *
     * @return ResponseInterface
     *
     */
    public function run(RequestInterface $request)
    {
        return $this($request);
    }

    /**
     *
     * Converts a queue entry to a callable, using the resolver if present.
     *
     * @param mixed $entry The queue entry.
     *
     * @return callable|MiddlewareInterface
     *
     * @throws RuntimeException when the queue is empty.
     *
     */
    protected function resolve($entry)
    {
        if (! $entry) {
            throw Exception::emptyQueue();
        }

        if (! $this->resolver) {
            return $entry;
        }

        return call_user_func($this->resolver, $entry);
    }
}
