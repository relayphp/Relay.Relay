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

    public function testInvalidQueue()
    {
        $this->setExpectedException(
            'Relay\Exception',
            'The middleware queue must be an array or a Traversable.'
        );

        $this->relayBuilder->newInstance('bad argument');
    }
}
