# Create a disallow function call rule

Were going to create slightly more advanced rules. 
We will work through an example where we are interested in properties of a node.

We'll also start developing rules by writing the tests first. From this point on all rules should be written test first.

## Demo 

Create a rule that does not allow calls to `var_dump`

#### Create test code

Snippet: `utils/Phpstan/Tests/DontCallVarDumpRule/Fixtures/var_dump.php`

```php
<?php

var_dump("Don't do this");
```
Test: `utils/Phpstan/Tests/DontCallVarDumpRule/DontCallVarDumpRuleTest.php`

```php
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
                'Using var_dump is not allowed',
                3,
            ],
        ]);
    }
}
```

#### Create empty rule

Rule: `utils/Phpstan/DontCallVarDumpRule.php`

```php
class DontCallVarDumpRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(get_class($node))->identifier('disallow.vardump')->build(),
        ];
    }
}
```

#### Update the rule

Run the test to see the output. Looks like we're interested in `FuncCall`. Let's update the rule...

```php
class DontCallVarDumpRule implements Rule
{
    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Using var_dump is not allowed")->identifier('disallow.vardump')->build(),
        ];
    }
}
```

#### Have we done the right thing?

A function call, can be for any function. What happens if we update our test snippet with another function call?

```php
<?php

var_dump("A message");

function isAdult(int $age): bool
{
    return $age >= 18;
}

isAdult(17);
```

Run tests. Get additional failure.

**TESTS MUST CHECK MORE THAN THE HAPPY PATH**

We need to check the name of the function we are calling too. Let's look at `FuncCall` in detail.

#### Get more information about the name node:

Update the rule to get more information about the `FuncCall`'s `name` node.

```php
    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(get_class($node->name))->identifier('disallow.vardump')->build(),
        ];
    }
```

#### Update the rule

We can see that `$node->name` is of type `FullyQualified`. This extends `Name` so we can use `toLowerString()` to get the name of the function.


```php
    public function processNode(Node $node, Scope $scope): array
    {
        $nameNode = $node->name;
        if (!$nameNode instanceof Node\Name) {
            return [];
        }

        if ($nameNode->toLowerString() !== 'var_dump') {
            return [];
        }

        return [
            RuleErrorBuilder::message('Using var_dump is not allowed')->identifier('disallow.vardump')->build(),
        ];
    }
```

Check everything works.

## Your turn


#### 1. Write a rule to disallow calls to compact

Follow steps we've just been through to create a rule to disallow calls to `compact`.


#### 2. Write a rule to disallow usage of $_GET

Follow the process we've been through to create this rule.


#### 3. Write a rule to disallow calling functions using an expression for the function name

E.g. Don't allow this:

```php
$function = 'var_dump';
$function('This is a var_dump call'); // Report error on this line
```