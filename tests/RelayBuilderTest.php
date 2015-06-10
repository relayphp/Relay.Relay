<?php
namespace Relay;

use ArrayObject;
use InvalidArgumentException;

class RelayBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $relayFactory;

    protected function setUp()
    {
        $this->relayFactory = new RelayBuilder();
    }

    public function testArray()
    {
        $queue = [];
        $relay = $this->relayFactory->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testArrayObject()
    {
        $queue = new ArrayObject([]);
        $relay = $this->relayFactory->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testGetArrayCopyInterface()
    {
        $queue = new FakeQueue();
        $relay = $this->relayFactory->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->relayFactory->newInstance('bad argument');
    }
}
