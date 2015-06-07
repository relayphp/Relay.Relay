<?php
namespace Pipeline\Pipeline;

class PipelineFactory
{
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    public function newInstance(array $queue)
    {
        return new Pipeline($queue, $this->resolver);
    }
}
