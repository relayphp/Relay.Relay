<?php
namespace Relay\Relay;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class RelayTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutResolver()
    {
        FakeMiddleware::$count = 0;

        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();

        $dispatcher = new Relay($queue);
        $response = $dispatcher(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('123456', $actual);
    }

    public function testWithResolver()
    {
        FakeMiddleware::$count = 0;

        $queue[] = 'Relay\Relay\FakeMiddleware';
        $queue[] = 'Relay\Relay\FakeMiddleware';
        $queue[] = 'Relay\Relay\FakeMiddleware';

        $resolver = function ($class) {
            return new $class();
        };

        $dispatcher = new Relay($queue, $resolver);
        $response = $dispatcher(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('123456', $actual);
    }
}
