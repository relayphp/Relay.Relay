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

use ArrayObject;
use InvalidArgumentException;

/**
 *
 * Builds a Relay object.
 *
 * @package Relay.Relay
 *
 */
class RelayBuilder
{
    /**
     *
     * Constructor.
     *
     * @param callable $resolver A resolver to convert queue entries to
     * callables.
     *
     * @return self
     *
     */
    public function __construct(callable $resolver = null)
    {
        $this->resolver = $resolver;
    }

    /**
     *
     * Returns a new Relay instance.
     *
     * @param array|ArrayObject|GetArrayCopyInterface $queue The queue for the
     * Relay.
     *
     * @return Relay
     *
     */
    public function newInstance($queue)
    {
        return new Relay($this->getArray($queue), $this->resolver);
    }

    /**
     *
     * Converts a queue specification to an array.
     *
     * @param array|ArrayObject|GetArrayCopyInterface $queue The queue
     * specification.
     *
     * @return array
     *
     */
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
