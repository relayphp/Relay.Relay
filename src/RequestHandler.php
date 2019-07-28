<?php
/**
 *
 * This file is part of Relay for PHP.
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @copyright 2015-2018, Paul M. Jones
 *
 */
namespace Relay;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Traversable;
use TypeError;
use function count;

/**
 *
 * An abstract PSR-15 request handler.
 *
 * @package relay/relay
 *
 */
abstract class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var array|Traversable
     */
    protected $queue;
    /**
     * @var callable
     */
    protected $resolver;
    
    /**
     *
     * Constructor.
     *
     * @param array|Traversable $queue A queue of middleware entries.
     *
     * @param callable $resolver Converts queue entries to middleware
     * instances.
     *
     */
    public function __construct($queue, callable $resolver = null)
    {
        if (! is_iterable($queue)) {
            throw new TypeError('\$queue must be array or Traversable.');
        }

        if (count($queue) === 0) {
            throw new InvalidArgumentException('$queue cannot be empty');
        }

        $this->queue = $queue;

        if ($resolver === null) {
            $resolver = function ($entry) {
                return $entry;
            };
        }

        $this->resolver = $resolver;
    }

    /**
     *
     * Handles the current entry in the middleware queue and advances.
     *
     * @param ServerRequestInterface $request The request.
     *
     * @return ResponseInterface
     *
     */
    abstract public function handle(ServerRequestInterface $request) : ResponseInterface;
}
