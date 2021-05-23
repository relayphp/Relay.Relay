<?php

namespace Relay;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

use function call_user_func;
use function current;
use function is_callable;
use function next;
use function sprintf;

/**
 * A PSR-15 request handler.
 */
class Runner extends RequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entry      = current($this->queue);
        $middleware = call_user_func($this->resolver, $entry);
        next($this->queue);

        if ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }

        if ($middleware instanceof RequestHandlerInterface) {
            return $middleware->handle($request);
        }

        if (is_callable($middleware)) {
            return $middleware($request, $this);
        }

        throw new RuntimeException(
            sprintf(
                'Invalid middleware queue entry: %s. Middleware must either be callable or implement %s.',
                $middleware,
                MiddlewareInterface::class
            )
        );
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handle($request);
    }
}
