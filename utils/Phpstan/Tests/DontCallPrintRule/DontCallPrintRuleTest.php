<?php

namespace Utils\Phpstan\Tests\DontCallPrintRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallPrintRule;

/** @extends RuleTestCase<DontCallPrintRule> */
class DontCallPrintRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallPrintRule();
    }

    public function testDontPrintRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/print.php'], [
            [
                "Don't call print",
                3,
            ],
        ]);
    }
}