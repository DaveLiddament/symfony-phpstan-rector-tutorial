<?php

namespace Utils\Phpstan\Tests\DontCallDieRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallDieRule;

/** @extends RuleTestCase<DontCallDieRule> */
class DontCallDieRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallDieRule();
    }

    public function testDontDieRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/die.php'], [
            [
                "Don't call die",
                3,
            ],
        ]);
    }
}