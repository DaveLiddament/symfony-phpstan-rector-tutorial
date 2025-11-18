# Configuring rules

We often have multiple rules that are very similar to each other. 
Or maybe we have rules that require configuration.

We can configure rules in PHPStan by passing arguments to the constructor.


## Demo

In the previous exercise we wrote a rule that disallows calls to `var_dump` and `compact`. 
Let's make a generic version of the rule that allows us to configure the functions that are disallowed.


#### Test

Create a fixture file `utils/Phpstan/Tests/DisallowFunctionRuleTest/Fixtures/myFunction.php`:

```php
<?php

function myFunction() {}

myFunction();
```

Then create the test `utils/Phpstan/Tests/DisallowFunctionRule/DisallowFunctionRuleTest.php`:

NOTE: We pass the disallowed function name as an argument to the constructor of the rule.

```php
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
```

#### Create a generic rule

Rule: `utils/Phpstan/Rules/DisallowFunctionRule.php`

```php
/** @implements  Rule<FuncCall> */
class DisallowFunctionRule implements Rule
{
    // Options available in the constructor
    public function __construct(
        private string $disallowedFunction
    ) {
    }

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nameNode = $node->name;
        if (!$nameNode instanceof Node\Name) {
            return [];
        }

        if ($nameNode->toLowerString() !== strtolower($this->disallowedFunction)) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Don't call {$this->disallowedFunction}")->identifier('disallow.function')->build(),
        ];
    }
}
```

#### Update config

Update PHPStan config `phpstan.neon`:

```
services:
-
    class: Utils\Phpstan\Rules\DisallowFunctionRule
    tags:
    - phpstan.rules.rule
    arguments:
      disallowedFunction: 'myFunction'

-
    class: Utils\Phpstan\Rules\DisallowFunctionRule
    tags:
    - phpstan.rules.rule
    arguments:
      disallowedFunction: 'var_dump'
```

## Your turn

Generalise the `PersonSetIdOnlyCalledFromTestCodeRule` so you can configure class name and method name
