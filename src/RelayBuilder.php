<?php

namespace Relay;

class RelayBuilder
{
    /** @var callable */
    protected $resolver;

    /**
     * @param callable $resolver Converts a given queue entry to a callable or MiddlewareInterface instance.
     */
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param iterable<mixed> $queue A queue of middleware entries.
     */
    public function newInstance($queue) : Relay
    {
        return new Relay($queue, $this->resolver);
    }
}
