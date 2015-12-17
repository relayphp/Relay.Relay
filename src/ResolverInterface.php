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
<<<<<<< HEAD
 * Formally defines the resolver interface signature required by Relay.
 *
 * Implementing this is completely voluntary. It is useful for indicating that
 * a class is intended for use as a resolver, and to ensure the `__invoke()`
 * method is typehinted correctly.
=======
 * This interface defines the interface for a resolver; that is, a callable
 * capable of converting entries from the middleware queue into a callable
 * or an implementation of MiddlewareInterface.
>>>>>>> 1.x
 *
 * @package Relay.Relay
 *
 */
interface ResolverInterface
{
    /**
<<<<<<< HEAD
     *
     * Converts a queue entry to a middleware callable.
     *
     * @param mixed $entry The queue entry.
     *
     * @return callable|MiddlewareInterface A middleware callable.
=======
     *
     * Converts a middleware queue entry to a callable or an implementation of
     * MiddlewareInterface.
     *
     * @param mixed $entry The middleware queue entry.
     *
     * @return callable|MiddlewareInterface
>>>>>>> 1.x
     *
     */
    public function __invoke($entry);
}
