<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

use App\Phpstan\CallableFrom;

class Item
{
    public function __construct(
        private string $name,
    ) {
    }

    #[CallableFrom(ItemUpdater::class)]
    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}