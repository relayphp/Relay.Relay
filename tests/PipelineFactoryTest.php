<?php
namespace Pipeline\Pipeline;

class PipelineFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $pipelineFactory = new PipelineFactory();
        $pipeline = $pipelineFactory->newInstance(array());
        $this->assertInstanceOf('Pipeline\Pipeline\Pipeline', $pipeline);
    }
}
