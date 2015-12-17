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
 * This interface defines the interface for a resolver; that is, a callable
 * capable of converting entries from the middleware queue into a callable
 * or an implementation of MiddlewareInterface.
 *
 * @package Relay.Relay
 *
 */
interface ResolverInterface
{
    /**
     *
     * Converts a middleware queue entry to a callable or an implementation of
     * MiddlewareInterface.
     *
     * @param mixed $entry The middleware queue entry.
     *
     * @return callable|MiddlewareInterface
     *
     */
    public function __invoke($entry);
}
