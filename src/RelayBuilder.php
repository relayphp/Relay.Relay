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


/**
 *
 * A builder to create Relay objects.
 *
 * @package Relay.Relay
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
     * @param callable|ResolverInterface $resolver A callable to convert a queue entry to
     * a callable|MiddlewareInterface in the Runner.
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
     * @param array|ArrayObject|GetArrayCopyInterface|Traversable $queue The
     * queue specification.
     *
     * @return Relay
     *
     */
    public function newInstance($queue) : Relay
    {
        return new Relay($queue, $this->resolver);
    }
}
