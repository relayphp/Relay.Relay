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
        $this->assertSame('1>2>3><3<2<1', $actual);

        // relay again
        $response = $relay(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );
        $actual = (string) $response->getBody();
        $this->assertSame('4>5>6><6<5<4', $actual);
    }
}
