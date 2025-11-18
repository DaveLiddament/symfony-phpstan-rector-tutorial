# ReflectionProvider

This is a bonus exercise. We won't have time for it during the workshop, but please have a go at home. 


Sometimes you'll need to write a rule that requires information about code that is not related to the node you are currently processing. 


## Demo

Look at the [CallableFrom](../../src/CallableFrom.php) attribute.

The aim is to make a rule that will enforce this attribute. 


#### Fixtures

`Item.php`:
```php
<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

use App\Phpstan\CallableFrom;

class Item
{
    public function __construct(
        private string $name,
    ) {
    }

    #[CallableFrom(ItemUpdater::class)]
    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
```

`ItemUpdater.php`
```php
<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

class ItemUpdater
{
    public function updateName(Item $item, string $name): void
    {
        $item->updateName($name); // OK, we're calling Item::updateName from ItemUpdater
    }
}
```

`SomeCode.php`
```php
<?php

namespace Utils\Phpstan\Tests\CallableFromRule\Fixtures;

class SomeCode
{
    public function go(): void
    {
        $item = new Item("hello");
        $item->updateName("world"); // ERROR, not allowed
    }
}
```

##### Test

```php
<?php

namespace Utils\Phpstan\Tests\CallableFromRule;

use PHPStan\Testing\RuleTestCase;
use PHPStan\Rules\Rule;
use Utils\Phpstan\Rules\CallableFromRule;

/** @extends RuleTestCase<CallableFromRule> */
class CallableFromRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new CallableFromRule($this->createReflectionProvider());
    }

    public function testInvalidCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ItemUpdater.php',
            ],
            [
            ]
        );
    }

    public function testAllowedCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    "Can not call method",
                    10,
                ]
            ]
        );
    }
}
```


#### Rule

```php
<?php

namespace Utils\Phpstan\Rules;

use App\Phpstan\CallableFrom;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/** @implements Rule<Node\Expr\MethodCall> */
class CallableFromRule implements Rule
{

    public function __construct(
        private ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        // Only interested in method calls where the name is an Identifier and not an expression
        if (! $node->name instanceof Node\Identifier) {
            return [];
        }

        $methodName = $node->name->name;

        // Get the name of the class that has the method making the call
        $callingClassName = $scope->getClassReflection()?->getName();

        if ($callingClassName === null) {
            return [];
        }

        $callingClassType = new ObjectType($callingClassName);

        // Loop through all the classes we are making the call on.
        // E.g. for the code below what object(s) does $this->item resolve to? 
        // $this->item->setName("hello") 
        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
        
            $reflectedClass = $this->reflectionProvider->getClass($referencedClass);

            // Drop down to native reflection
            $nativeReflection = $reflectedClass->getNativeReflection();
            if (! $nativeReflection->hasMethod($methodName)) {
                continue;
            }
            
            // Get native reflection of method and check if it has the CallableFrom attribute
            $reflectedMethod = $nativeReflection->getMethod($methodName);
            $callableFromAttributes = $reflectedMethod->getAttributes(CallableFrom::class);
            
            // Iterate through all the CallableFrom attributes on the method
            foreach($callableFromAttributes as $callableFromAttribute) {
            
                // Get the first argument of the CallableFrom attribute (if it exists)
                // This is the FQCN of the class that is allowed to call this method
                $arguments = $callableFromAttribute->getArguments();
                if (count($arguments) !== 1) {
                    continue;
                }

                // Check if the class that is calling the method is allowed to call the method. 
                // If not return an error
                if (!$callingClassType->isInstanceOf($arguments[0])->yes()) {
                    return [
                        RuleErrorBuilder::message("Can not call method")->identifier('callablefrom')->build(),
                    ];
                }
            }
        }

        return [];
    }
}
```

## Your turn

Create a rule that allows you to restrict who can instantiate a new class E.g. 

```php


class Person
{
    #[CallableFrom(PersonBuilder::class)] 
    public function __construct()
    {
        // Only PersonBuilder can call this
    }
}

```


Check out [PHP Language Extension library](https://github.com/DaveLiddament/php-language-extensions) and the [PHPStan extension](https://github.com/DaveLiddament/phpstan-php-language-extensions) for implementations along this line. 