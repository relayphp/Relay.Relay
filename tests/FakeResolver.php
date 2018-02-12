<?php
namespace Relay;

class FakeResolver
{
    public function __invoke($entry)
    {
        if (is_string($entry)) {
            return new $entry();
        }

        return $entry;
    }
}
