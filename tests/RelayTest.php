<?php
namespace Relay;

use ArrayObject;
use TypeError;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class RelayTest extends \PHPUnit\Framework\TestCase
{
    protected $responder;

    protected function setUp()
    {
        $this->responder = function ($request, $next) {
            return new Response();
        };
    }

    protected function assertRelay($relay)
    {
        FakeMiddleware::$count = 0;

        // relay once
        $response = $relay->handle(ServerRequestFactory::fromGlobals());
        $actual = (string) $response->getBody();
        $this->assertSame('<3<2<1', $actual);

        // relay again
        $response = $relay->handle(ServerRequestFactory::fromGlobals());
        $actual = (string) $response->getBody();
        $this->assertSame('<6<5<4', $actual);
    }

    public function testArrayQueue()
    {
        $queue = [
            new FakeMiddleware(),
            new FakeMiddleware(),
            new FakeMiddleware(),
            $this->responder,
        ];

        $this->assertRelay(new Relay($queue));
    }

    public function testTraversableQueue()
    {
        $queue = new ArrayObject([
            new FakeMiddleware(),
            new FakeMiddleware(),
            new FakeMiddleware(),
            $this->responder,
        ]);

        $this->assertRelay(new Relay($queue));
    }

    public function testBadQueue()
    {
        $this->expectException(TypeError::CLASS);
        $relay = new Relay('bad');
    }

    public function testResolverEntries()
    {
        $queue = [
            FakeMiddleware::CLASS,
            FakeMiddleware::CLASS,
            FakeMiddleware::CLASS,
            $this->responder,
        ];

        $resolver = new FakeResolver();

        $this->assertRelay(new Relay($queue, $resolver));
    }
}
