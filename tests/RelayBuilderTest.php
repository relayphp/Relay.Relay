<?php
namespace Relay;

use ArrayObject;
use InvalidArgumentException;
use Traversable;

class RelayBuilderTest extends \PHPUnit_Framework_TestCase
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

        $queue = $this->getMock(ArrayObject::class);
        $queue
            ->expects($this->once())
            ->method('getArrayCopy')
            ->willReturn([]);

        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testGetArrayCopyInterface()
    {
        $queue = new FakeQueue();
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testTraversable()
    {
        $queue = $this->getMock(Traversable::class);

        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->relayBuilder->newInstance('bad argument');
    }
}
