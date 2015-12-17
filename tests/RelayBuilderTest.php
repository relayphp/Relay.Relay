<?php
namespace Relay;

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
