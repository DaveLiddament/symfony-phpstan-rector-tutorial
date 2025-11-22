<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

class SomeCode
{
    public function go(): void
    {
        $item = new Item("hello");
        $item->updateName("world"); // ERROR, not allowed
    }
}