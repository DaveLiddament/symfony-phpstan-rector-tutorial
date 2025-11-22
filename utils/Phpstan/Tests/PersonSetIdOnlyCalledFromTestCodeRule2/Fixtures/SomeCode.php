<?php

declare(strict_types=1);

namespace Utils\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule2\Fixtures;

use App\Phpstan\Person;

class SomeCode
{
    public function setIdOnEntity(Person $entity): void
    {
        $entity->setId(7); // ERROR, not allowed
    }

    public function setIdOnNoneEntity(NotAnEntity $notAnEntity): void
    {
        $notAnEntity->setId(); // OK, not an entity
    }
}