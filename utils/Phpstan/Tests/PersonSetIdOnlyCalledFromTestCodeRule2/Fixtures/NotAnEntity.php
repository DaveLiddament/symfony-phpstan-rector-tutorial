<?php

declare(strict_types=1);

namespace Utils\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule2\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}