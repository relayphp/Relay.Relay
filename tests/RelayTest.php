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

        $builder = new RelayBuilder();
        $relay = $builder->newInstance($queue);

        // relay once
        $response = $relay->run(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );
        $actual = (string) $response->getBody();
        $this->assertSame('123456', $actual);

        // relay again
        $response = $relay(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );
        $actual = (string) $response->getBody();
        $this->assertSame('789101112', $actual);
    }
}
