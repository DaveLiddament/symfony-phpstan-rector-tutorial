<?php

namespace Utils\Phpstan\Tests\DontCallCompactRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallCompactRule;

/** @extends RuleTestCase<DontCallCompactRule> */
class DontCallCompactRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallCompactRule();
    }

    public function testDontCompactRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/compact.php'], [
            [
                "Don't call compact",
                6,
            ],
        ]);
    }
}