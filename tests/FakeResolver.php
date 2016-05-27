<?php
namespace Relay;

use Closure;

class FakeResolver implements ResolverInterface
{
    public function __invoke($entry)
    {
        if ($entry instanceof Closure) {
            return $entry;
        }

        return new $entry();
    }
}
