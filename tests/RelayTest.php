<?php

namespace Relay;

use Closure;
use InvalidArgumentException;
use IteratorAggregate;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use TypeError;

class RelayTest extends TestCase
{
    /** @var Closure */
    protected $responder;

    protected function setUp() : void
    {
        $this->responder = function ($request, $next) {
            return new Response();
        };
    }

    protected function assertRelay(Relay $relay)
    {
        FakeMiddleware::$count = 0;

        // relay once
        $response = $relay->handle(ServerRequestFactory::fromGlobals());
        $actual   = (string) $response->getBody();
        $this->assertSame('<3<2<1', $actual);

        // relay again
        $response = $relay->handle(ServerRequestFactory::fromGlobals());
        $actual   = (string) $response->getBody();
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
        $queue = new class implements IteratorAggregate {
            public function getIterator()
            {
                yield new FakeMiddleware();
                yield new FakeMiddleware();
                yield new FakeMiddleware();
                yield function ($request, $next) {
                    return new Response();
                };
            }
        };

        $this->assertRelay(new Relay($queue));
    }

    /**
     * @psalm-suppress InvalidArgument
     */
    public function testBadQueue()
    {
        $this->expectException(TypeError::class);
        new Relay('bad');
    }

    public function testEmptyQueue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$queue cannot be empty');

        new Relay([]);
    }

    public function testQueueWithInvalidEntry()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Invalid middleware queue entry: bad. Middleware must either be callable or implement Psr\Http\Server\MiddlewareInterface.'
        );

        $relay = new Relay(['bad']);
        $relay->handle(ServerRequestFactory::fromGlobals());
    }

    public function testResolverEntries()
    {
        $queue = [
            FakeMiddleware::class,
            FakeMiddleware::class,
            FakeMiddleware::class,
            $this->responder,
        ];

        $resolver = new FakeResolver();

        $this->assertRelay(new Relay($queue, $resolver));
    }

    public function testRequestHandlerInQueue()
    {
        $queue          = [
            new FakeMiddleware(),
            new FakeMiddleware(),
            new FakeMiddleware(),
            $this->responder,
        ];
        $requestHandler = new Relay($queue);
        $this->assertRelay(new Relay([$requestHandler]));
    }

    public function testCallableMiddleware()
    {
        $queue = [
            function (
                ServerRequestInterface $request,
                callable $next
            ) : ResponseInterface {
                $response = $next($request);

                $response->getBody()->write('Hello, callable world!');

                return $response;
            },
            $this->responder,
        ];

        $relay    = new Relay($queue);
        $response = $relay->handle(ServerRequestFactory::fromGlobals());

        $this->assertEquals('Hello, callable world!', (string) $response->getBody());
    }
}
