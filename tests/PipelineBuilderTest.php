<?php
namespace Pipeline\Pipeline;

use ArrayObject;
use InvalidArgumentException;

class PipelineBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $pipelineFactory;

    protected function setUp()
    {
        $this->pipelineFactory = new PipelineBuilder();
    }

    public function testArray()
    {
        $queue = [];
        $pipeline = $this->pipelineFactory->newInstance($queue);
        $this->assertInstanceOf('Pipeline\Pipeline\Pipeline', $pipeline);
    }

    public function testArrayObject()
    {
        $queue = new ArrayObject([]);
        $pipeline = $this->pipelineFactory->newInstance($queue);
        $this->assertInstanceOf('Pipeline\Pipeline\Pipeline', $pipeline);
    }

    public function testGetArrayCopyInterface()
    {
        $queue = new FakeQueue();
        $pipeline = $this->pipelineFactory->newInstance($queue);
        $this->assertInstanceOf('Pipeline\Pipeline\Pipeline', $pipeline);
    }

    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->pipelineFactory->newInstance('bad argument');
    }
}
