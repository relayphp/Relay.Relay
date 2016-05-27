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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 *
 * A multiple-use PSR-7 middleware dispatcher.
 *
 * @package relay/relay
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
     * Dispatches to a new Runner; essentially an alias to `__invoke()`.
     *
     * @param RequestInterface $request The request.
     *
     * @param ResponseInterface $response The response.
     *
     * @return ResponseInterface
     *
     */
    public function run(RequestInterface $request)
    {
        $runner = $this->runnerFactory->newInstance();
        return $runner($request);
    }
}
