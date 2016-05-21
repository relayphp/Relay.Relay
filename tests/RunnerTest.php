<?php
namespace Relay;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class RunnerTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutResolver()
    {
        FakeMiddleware::$count = 0;

        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();

        $runner = new Runner($queue);
        $response = $runner->run(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('1>2>3><3<2<1', $actual);
    }

    public function testWithResolver()
    {
        FakeMiddleware::$count = 0;

        $queue[] = 'Relay\FakeMiddleware';
        $queue[] = 'Relay\FakeMiddleware';
        $queue[] = 'Relay\FakeMiddleware';

        $resolver = new FakeResolver();

        $runner = new Runner($queue, $resolver);
        $response = $runner(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('1>2>3><3<2<1', $actual);
    }

    public function testUnexpectedValue()
    {
        $this->setExpectedException('UnexpectedValueException');

        $queue[] = function () {
            return;
        };

        $runner = new Runner($queue);
        $runner->run(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );
    }

    public function testWithSubRunner()
    {
        FakeMiddleware::$count = 0;

        $runner = new Runner([
            new Runner([
                new FakeMiddleware(),
                new FakeMiddleware(),
                new Runner([
                    new FakeMiddleware(),
                    new FakeMiddleware(),
                ]),
            ]),
            new FakeMiddleware()
        ]);

        $response = $runner(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('1>2>3>4>5><5<4<3<2<1', $actual);
    }
}
