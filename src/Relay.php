<?php

namespace Relay;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function reset;

/**
 * A reusable PSR-15 request handler.
 */
class Relay extends RequestHandler
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        reset($this->queue);
        $runner = new Runner($this->queue, $this->resolver);

        return $runner->handle($request);
    }
}
