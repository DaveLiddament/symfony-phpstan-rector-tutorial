<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

class ItemUpdater
{
    public function updateName(Item $item, string $name): void
    {
        $item->updateName($name);
    }
}