<?php
namespace Relay;

use ArrayObject;
use InvalidArgumentException;
use Traversable;

class RelayBuilderTest extends \PHPUnit\Framework\TestCase
{
    protected $relayBuilder;

    protected function setUp()
    {
        $this->relayBuilder = new RelayBuilder();
    }

    public function testArray()
    {
        $queue = [];
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testArrayObject()
    {
        $queue = new ArrayObject([]);
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testTraversable()
    {
        $queue = $this->createMock(Traversable::class);

        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testInvalidArgument()
    {
        $this->expectException('TypeError');
        $this->relayBuilder->newInstance('bad argument');
    }
}
