<?php

namespace Utils\Phpstan\Tests\DontCallExitRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallExitRule;

/** @extends RuleTestCase<DontCallExitRule> */
class DontCallExitRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallExitRule();
    }

    public function testDontExitRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/exit.php'], [
            [
                "Don't call exit",
                3,
            ],
        ]);
    }
}