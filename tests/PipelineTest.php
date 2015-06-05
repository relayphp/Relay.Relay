<?php
namespace Pipeline\Pipeline;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class PipelineTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutResolver()
    {
        FakeMiddleware::$count = 0;

        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();
        $queue[] = new FakeMiddleware();

        $dispatcher = new Pipeline($queue);
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

        $queue[] = 'Pipeline\Pipeline\FakeMiddleware';
        $queue[] = 'Pipeline\Pipeline\FakeMiddleware';
        $queue[] = 'Pipeline\Pipeline\FakeMiddleware';

        $resolver = function ($class) {
            return new $class();
        };

        $dispatcher = new Pipeline($queue, $resolver);
        $response = $dispatcher(
            ServerRequestFactory::fromGlobals(),
            new Response()
        );

        $actual = (string) $response->getBody();
        $this->assertSame('123456', $actual);
    }
}
