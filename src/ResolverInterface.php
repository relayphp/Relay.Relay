<?php

namespace Relay;

/**
 * This interface defines the interface for a resolver - a function capable of
 * converting entries from the middleware queue into `callable|MiddlewareInterface`
 */
interface ResolverInterface
{
    /**
     * @param mixed $entry
     *
     * @return callable|MiddlewareInterface
     */
    public function __invoke($entry);
}
