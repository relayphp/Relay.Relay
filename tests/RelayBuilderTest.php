<?php
namespace Relay;

use ArrayObject;
use InvalidArgumentException;

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
    }

    public function testGetArrayCopyInterface()
    {
        $queue = new FakeQueue();
        $relay = $this->relayBuilder->newInstance($queue);
        $this->assertInstanceOf('Relay\Relay', $relay);
    }

    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->relayBuilder->newInstance('bad argument');
    }
}
