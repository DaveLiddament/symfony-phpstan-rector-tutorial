<?php

namespace Utils\Phpstan\Tests\DontAllowGetSuperGlobalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DontAllowGetSuperGlobalRule;

/** @extends RuleTestCase<DontAllowGetSuperGlobalRule> */
class DontAllowGetSuperGlobalRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontAllowGetSuperGlobalRule();
    }

    public function testDontCompactRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/get.php'], [
            [
                'Don\'t use $_GET',
                3,
            ],
        ]);
    }
}