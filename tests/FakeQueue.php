<?php
namespace Relay\Relay;

class FakeQueue implements GetArrayCopyInterface
{
    public function getArrayCopy()
    {
        return [];
    }
}
