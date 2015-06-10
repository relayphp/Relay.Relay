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
 * Allows queue-building objects to return an array copy.
 *
 * @package Relay.Relay
 *
 */
interface GetArrayCopyInterface
{
    /**
     *
     * Returns an array copy of the queue.
     *
     * @return array
     *
     */
    public function getArrayCopy();
}
