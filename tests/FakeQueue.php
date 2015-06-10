<?php
namespace Relay;

class FakeQueue implements GetArrayCopyInterface
{
    public function getArrayCopy()
    {
        return [];
    }
}
