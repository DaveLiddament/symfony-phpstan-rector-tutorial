<?php

declare(strict_types=1);

namespace App\Test;

use App\Phpstan\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    private const NAME = 'Dave';

    public function testGetName(): void
    {
        $person = new Person(self::NAME);
        $this->assertSame(self::NAME, $person->getName());
    }
}
