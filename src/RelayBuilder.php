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

use Traversable;

/**
 *
 * A builder to create Relay objects.
 *
 * @package relay/relay
 *
 */
class RelayBuilder
{
    /**
     *
     * A callable to convert queue entries to callables in the Runner.
     *
     * @var callable|ResolverInterface
     *
     */
    protected $resolver;

    /**
     *
     * Constructor.
     *
     * @param callable|ResolverInterface $resolver A callable to convert a queue
     * entry to a callable|MiddlewareInterface in the Runner.
     *
     */
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    /**
     *
     * Creates a new Relay with the specified queue for its Runner objects.
     *
     * @param array|Traversable $queue The queue specification.
     *
     * @return Relay
     *
     */
    public function newInstance($queue)
    {
        return new Relay($this->newRunnerFactory($queue));
    }

    /**
     *
     * Creates a new RunnerFactory with a specified queue.
     *
     * @param array|Traversable $queue The queue specification.
     *
     * @return RunnerFactory
     *
     */
    protected function newRunnerFactory($queue)
    {
        if ($queue instanceof Traversable) {
            $queue = iterator_to_array($queue);
        }

        if (! is_array($queue)) {
            throw Exception::invalidQueue();
        }

        return new RunnerFactory($queue, $this->resolver);
    }
}
