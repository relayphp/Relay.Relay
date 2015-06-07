<?php
namespace Pipeline\Pipeline;

class FakeQueue implements GetArrayCopyInterface
{
    public function getArrayCopy()
    {
        return [];
    }
}
