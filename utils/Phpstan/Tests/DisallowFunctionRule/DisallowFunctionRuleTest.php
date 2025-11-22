<?php

namespace Utils\Phpstan\Tests\DisallowFunctionRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Utils\Phpstan\Rules\DisallowFunctionRule;

/** @extends RuleTestCase<DisallowFunctionRule> */
class DisallowFunctionRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DisallowFunctionRule(
            disallowedFunction: 'myFunction',
        );
    }

    public function testDisallowedFunction(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixtures/myFunction.php'],
            [
                [
                    'Don\'t call myFunction',
                    5,
                ],
            ]
        );
    }
}