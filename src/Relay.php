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

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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
     * @param Request $request The request.
     *
     * @param Response $response The response.
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response)
    {
        $runner = $this->runnerFactory->newInstance();
        return $runner($request, $response);
    }
}
