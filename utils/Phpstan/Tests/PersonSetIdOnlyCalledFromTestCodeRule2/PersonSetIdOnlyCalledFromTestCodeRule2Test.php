<?php

declare(strict_types=1);


namespace Utils\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule2;


use Utils\Phpstan\Rules\PersonSetIdOnlyCalledFromTestCodeRule2;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<PersonSetIdOnlyCalledFromTestCodeRule2> */
class PersonSetIdOnlyCalledFromTestCodeRule2Test extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new PersonSetIdOnlyCalledFromTestCodeRule2();
    }

    public function testCallSetIdFromTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/PersonTest.php',
            ],
            [],
        );
    }

    public function testCallSetIdOutsideOfTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    'Can not call Person::setId outside of a test',
                    13,
                ],
            ],
        );
    }
}