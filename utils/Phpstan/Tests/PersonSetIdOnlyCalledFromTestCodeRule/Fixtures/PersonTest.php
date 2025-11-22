<?php

declare(strict_types=1);

namespace Utils\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

use App\Phpstan\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testSetId(): void
    {
        $companyEntity = new Person("bob");
        $companyEntity->setId(7); // OK
        $this->assertSame(7, $companyEntity->getId());
    }
}