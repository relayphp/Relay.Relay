<?php

namespace Relay;

use ArrayObject;
use Generator;
use InvalidArgumentException;
use IteratorAggregate;
use PHPUnit\Framework\TestCase;

class RelayBuilderTest extends TestCase
{
    /** @var RelayBuilder */
    protected $relayBuilder;

    protected function setUp(): void
    {
        $this->relayBuilder = new RelayBuilder();
    }

    public function testArray(): void
    {
        $queue = [new FakeMiddleware()];
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testArrayObject(): void
    {
        $queue = new ArrayObject([new FakeMiddleware()]);
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testTraversable(): void
    {
        $queue = new class implements IteratorAggregate {
            public function getIterator(): Generator
            {
                yield new FakeMiddleware();
            }
        };

        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    /**
     * @psalm-suppress InvalidArgument
     */
    public function testInvalidArgument(): void
    {
        $this->expectException('TypeError');
        $this->relayBuilder->newInstance('bad argument');
    }

    public function testEmptyQueue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$queue cannot be empty');

        $this->relayBuilder->newInstance([]);
    }
}
