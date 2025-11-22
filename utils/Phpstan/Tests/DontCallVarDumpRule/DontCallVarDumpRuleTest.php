<?php

namespace Utils\Phpstan\Tests\DontCallVarDumpRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontCallVarDumpRule;

/** @extends RuleTestCase<DontCallVarDumpRule> */
class DontCallVarDumpRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallVarDumpRule();
    }

    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/var_dump.php'], [
            [
                'Don\'t call var_dump',
                3,
            ],
        ]);
    }
}