<?php

namespace Relay;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

use function is_array;
use function is_iterable;
use function iterator_to_array;

/**
 * An abstract PSR-15 request handler.
 */
abstract class RequestHandler implements RequestHandlerInterface
{
    /** @var mixed[] */
    protected $queue;
    /** @var callable */
    protected $resolver;

    /**
     * @param iterable<mixed> $queue    A queue of middleware entries.
     * @param callable        $resolver Converts a given queue entry to a callable or MiddlewareInterface instance.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function __construct($queue, ?callable $resolver = null)
    {
        if (! is_iterable($queue)) {
            throw new TypeError('\$queue must be array or Traversable.');
        }

        if (! is_array($queue)) {
            $queue = iterator_to_array($queue);
        }

        if (empty($queue)) {
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
     * Handles the current entry in the middleware queue and advances.
     */
    abstract public function handle(ServerRequestInterface $request): ResponseInterface;
}
