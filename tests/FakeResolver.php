<?php

namespace Relay;

use Psr\Http\Server\MiddlewareInterface;

use function is_string;

class FakeResolver
{
    /**
     * @param string|callable|MiddlewareInterface $entry
     *
     * @return callable|MiddlewareInterface
     */
    public function __invoke($entry)
    {
        if (is_string($entry)) {
            return new $entry();
        }

        return $entry;
    }
}
