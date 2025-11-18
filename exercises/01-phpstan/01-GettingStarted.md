# Getting Started

This aim of this section is to create your first PHPStan rules. 
These will disallow language features, e.g. `echo`, `print`, `var_dump`, etc.


## Before you start

1. Make sure you have completed all the "Pre tutorial setup" steps in the [README](../README.md).
1. There is a 20-minute lecture that acts an introduction to the tutorial.

## Demo

Together we'll create a rule that disallows usages of `print`. 

#### Create code that calls print

Create a file `src/Phpstan/print.php` with the contents:

```php
<?php

print("This is not allowed");
```

#### Create a directory for storing PHPStan rules

For this tutorial we'll use `utils\Phpstan\Rules`

Update `composer.json`, add following to `autoload-dev`:

```
 "Utils\\Phpstan\\": "utils/Phpstan/"
```

Don't forget to run `composer dump-autoload`.

#### Create a rule

Create a new class `utils\Phpstan\Rules\DontCallPrintRule.php`

```php
<?php

declare(strict_types=1);

namespace Utils\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class DontCallPrintRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        var_dump(get_class($node));
        return [];
    }
}
```

Update `phpstan.neon` add a service section:

```yml
services:
-
    class: Utils\Phpstan\Rules\DontCallPrintRule
    tags:
    - phpstan.rules.rule
```


Run PHPStan to dump out errors:

```bash
vendor/bin/phpstan analyse --debug src/Phpstan/print.php 
```

Or with docker:
```bash
 docker compose run --rm php83 vendor/bin/phpstan analyse --debug /app/src/Phpstan/print.php
```


You should see something like this:
```
string(21) "PHPStan\Node\FileNode"
string(30) "PhpParser\Node\Stmt\Expression"
string(26) "PhpParser\Node\Expr\Print_"
string(29) "PhpParser\Node\Scalar\String_"
string(23) "PhpParser\Node\Stmt\Nop"
```

It is the `PhpParser\Node\Expr\Print_` node we want to look for. 

Update the rule:

```php
    public function getNodeType(): string
    {
        return Node\Expr\Print_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't call print")->identifier('disallow.print')->build(),
        ];
    }
```

Rerun PHPStan, is it working how you expect?


## Your turn

Follow the process above to create rules to disallow:

- `echo`
- `exit`
- `goto`
- `die`
