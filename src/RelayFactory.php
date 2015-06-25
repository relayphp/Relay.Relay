<?php
namespace Relay;

class RelayFactory
{
    protected $queue;
    protected $resolver;

    public function __construct(array $queue, $resolver = null)
    {
        $this->queue = $queue;
        $this->resolver = $resolver;
    }

    public function newInstance()
    {
        return new Relay($this->queue, $this->resolver);
    }
}
