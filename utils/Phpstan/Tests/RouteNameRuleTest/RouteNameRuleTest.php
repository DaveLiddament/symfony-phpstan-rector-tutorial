<?php

declare(strict_types=1);


namespace Utils\Phpstan\Tests\RouteNameRuleTest;


use Utils\Phpstan\Rules\RouteNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<RouteNameRule> */
class RouteNameRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new RouteNameRule();
    }

    public function testPositionalArguments(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/PositionalArgumentsController.php',
            ],
            [
                [
                    'Route name must be snake_case',
                    9,
                ],
            ],
        );
    }

    public function testNamedArguments(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/NamedArgumentsController.php',
            ],
            [
                [
                    'Route name must be snake_case',
                    20,
                ],
                [
                    'Route name must be snake_case',
                    26,
                ],

            ],
        );
    }

}