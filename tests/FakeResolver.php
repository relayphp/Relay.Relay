<?php
namespace Relay;

class FakeResolver implements ResolverInterface
{
    public function __invoke($class)
    {
        return new $class();
    }
}
