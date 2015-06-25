<?php
namespace Relay;

use ArrayObject;
use InvalidArgumentException;

class ReusableRelayBuilder
{
    protected $resolver;

    public function __construct($resolver = null)
    {
        $this->resolver = $resolver;
    }

    public function newInstance($queue)
    {
        return new ReusableRelay($this->newRelayFactory($queue));
    }

    protected function newRelayFactory($queue)
    {
        return new RelayFactory(
            $this->getArray($queue),
            $this->resolver
        );
    }

    protected function getArray($queue)
    {
        if (is_array($queue)) {
            return $queue;
        }

        $getArrayCopy = $queue instanceof GetArrayCopyInterface
            || $queue instanceof ArrayObject;

        if ($getArrayCopy) {
            return $queue->getArrayCopy();
        }

        throw new InvalidArgumentException();
    }
}
