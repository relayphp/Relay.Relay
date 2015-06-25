<?php
namespace Relay;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ReusableRelay
{
    protected $relayFactory;

    public function __construct(RelayFactory $relayFactory)
    {
        $this->relayFactory = $relayFactory;
    }

    public function __invoke(Request $request, Response $response)
    {
        $relay = $this->relayFactory->newInstance();
        return $relay($request, $response);
    }
}
