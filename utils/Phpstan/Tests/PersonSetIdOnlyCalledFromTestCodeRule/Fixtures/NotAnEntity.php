<?php

declare(strict_types=1);

namespace Utils\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}