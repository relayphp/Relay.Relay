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

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 * A multiple-use PSR-7 middleware dispatcher.
 *
 * @package Relay.Relay
 *
 */
class Relay
{
    /**
     *
     * A factory to create Runner objects.
     *
     * @var RunnerFactory
     *
     */
    protected $runnerFactory;

    /**
     *
     * Constructor.
     *
     * @param RunnerFactory $runnerFactory A factory to create Runner objects.
     *
     */
    public function __construct(RunnerFactory $runnerFactory)
    {
        $this->runnerFactory = $runnerFactory;
    }

    /**
     *
     * Dispatches to a new Runner.
     *
     * @param ServerRequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @return ResponseInterface
     *
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $runner = $this->runnerFactory->newInstance();
        return $runner($request, $response);
    }

    /**
     *
     * Dispatches to a new Runner; essentially an alias to `__invoke()`.
     *
     * @param ServerRequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @return ResponseInterface
     *
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this($request, $response);
    }
}
