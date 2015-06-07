<?php
/**
 *
 * This file is part of Pipeline for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2015, Paul M. Jones
 *
 */
namespace Pipeline\Pipeline;

/**
 *
 * Allows queue-building objects to return an array copy.
 *
 * @package Pipeline.Pipeline
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
