<?php
namespace Pipeline\Pipeline;

use ArrayObject;
use InvalidArgumentException;

class PipelineBuilder
{
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    public function newInstance($queue)
    {
        return new Pipeline($this->getArray($queue), $this->resolver);
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
