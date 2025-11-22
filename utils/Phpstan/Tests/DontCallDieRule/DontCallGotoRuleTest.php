<?php

namespace Utils\Phpstan\Tests\DontCallGotoRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallGotoRule;

/** @extends RuleTestCase<DontCallGotoRule> */
class DontCallGotoRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallGotoRule();
    }

    public function testDontGotoRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/goto.php'], [
            [
                "Don't call goto",
                5,
            ],
        ]);
    }
}