<?php
/**
 *
 * This file is part of Relay for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2015, Paul M. Jones
 *
 */
namespace Relay;

/**
 *
 * Formally defines the resolver interface signature required by Relay.
 *
 * Implementing this is completely voluntary. It is useful for indicating that
 * a class is intended for use as a resolver, and to ensure the `__invoke()`
 * method is typehinted correctly.
 *
 * @package Relay.Relay
 *
 */
interface ResolverInterface
{
    /**
     *
     * Convers a queue entry to a middleware callable.
     *
     * @param mixed $entry The queue entry.
     *
     * @return callable|MiddlewareInterface A middleware callable.
     *
     */
    public function __invoke($entry);
}
