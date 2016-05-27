<?php
namespace Relay;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class RunnerTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutResolver()
    {
        FakeMiddleware::$count = 0;

        $queue = [
            new FakeMiddleware(),
            new FakeMiddleware(),
            new FakeMiddleware(),
            function ($request, $next) {
                return new Response();
            },
        ];

        $runner = new Runner($queue);
        $response = $runner->run(ServerRequestFactory::fromGlobals());

        $actual = (string) $response->getBody();
        $this->assertSame('123', $actual);
    }

    public function testWithResolver()
    {
        FakeMiddleware::$count = 0;

        $queue = [
            new FakeMiddleware(),
            new FakeMiddleware(),
            new FakeMiddleware(),
            function ($request, $next) {
                return new Response();
            },
        ];

        $resolver = new FakeResolver();

        $runner = new Runner($queue, $resolver);
        $response = $runner->run(ServerRequestFactory::fromGlobals());

        $actual = (string) $response->getBody();
        $this->assertSame('123', $actual);
    }

    public function testEmptyQueue()
    {
        $resolver = new FakeResolver();
        $queue = [];
        $runner = new Runner($queue, $resolver);
        $this->setExpectedException(
            'Relay\Exception',
            'The middleware queue is empty.'
        );
        $runner->run(ServerRequestFactory::fromGlobals());
    }
}
