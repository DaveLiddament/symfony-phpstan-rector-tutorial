<?php

namespace Utils\Phpstan\Tests\CallableFromRule;

use PHPStan\Testing\RuleTestCase;
use PHPStan\Rules\Rule;
use Utils\Phpstan\Rules\CallableFromRule;

/** @extends RuleTestCase<CallableFromRule> */
class CallableFromRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new CallableFromRule($this->createReflectionProvider());
    }

    public function testInvalidCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ItemUpdater.php',
            ],
            [
            ]
        );
    }

    public function testAllowedCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    "Can not call method",
                    10,
                ]
            ]
        );
    }
}