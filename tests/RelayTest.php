<?php
namespace Relay;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class RelayTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        FakeMiddleware::$count = 0;

        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();
        $queue[] = function ($request, $next) {
            return new Response();
        };

        $builder = new RelayBuilder();
        $relay = $builder->newInstance($queue);

        // relay once
        $response = $relay->run(ServerRequestFactory::fromGlobals());
        $actual = (string) $response->getBody();
        $this->assertSame('123', $actual);

        // relay again
        $response = $relay->run(ServerRequestFactory::fromGlobals());
        $actual = (string) $response->getBody();
        $this->assertSame('456', $actual);
    }
}
