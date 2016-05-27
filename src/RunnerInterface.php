<?php
/**
 *
 * This file is part of Relay for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2016, Paul M. Jones
 *
 */
namespace Relay;

use Psr\Http\Message\RequestInterface;

/**
 *
 * This interface defines the runner interface signature required by Relay.
 *
 * Implementing this is completely voluntary, it's mostly useful for indicating
 * that your class is a runner, and to ensure you type-hint the `__invoke()`
 * method signature correctly.
 *
 * @package relay/relay
 *
 */
interface RunnerInterface
{
    /**
     *
     * Runs the next entry in the queue.
     *
     * @param RequestInterface $request The request.
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(RequestInterface $request);
}
