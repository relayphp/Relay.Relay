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

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 * A reusable PSR-15 request handler.
 *
 * @package relay/relay
 *
 */
class Relay extends RequestHandler
{
    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        reset($this->queue);
        $runner = new Runner($this->queue, $this->resolver);
        return $runner->handle($request);
    }
}
