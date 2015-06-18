<?php
namespace Relay;

class RunnerFactory
{
    public function __construct(array $queue, $resolver)
    {
        $this->queue = $queue;
        $this->resolver = $resolver;
    }

    // @TODO Note that the resolver will re-resolve each queue entry for the
    // Runner, since the queue is re-injected from the factory property by copy.
    public function newInstance()
    {
        return new Runner($this->queue, $this->resolver);
    }
}
