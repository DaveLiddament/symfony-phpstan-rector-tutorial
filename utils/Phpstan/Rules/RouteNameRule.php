<?php

namespace Utils\Phpstan\Rules;

use App\Phpstan\Route;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Attribute> */
class RouteNameRule implements Rule
{

    public function getNodeType(): string
    {
        return Node\Attribute::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->name->toString() !== Route::class) {
            return [];
        }

        $nameArg = null;

        // Get via positional arguments
        $secondArg = $node->args[1] ?? null;
        if ($secondArg !== null && $secondArg->name === null) {
            $nameArg = $secondArg;
        }

        // Get via named arguments
        foreach($node->args as $arg) {
            if ($arg->name !==  null && $arg->name->toString() === 'name') {
                $nameArg = $arg;
            }
       }

        if ($nameArg === null) {
            return [];
        }

        $value = $nameArg->value;

        if (!$value instanceof Node\Scalar\String_) {
            return [];
        }

        // check if $value is snake_case
        if (preg_match('/^[a-z0-9_]+$/', $value->value)) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Route name must be snake_case")->identifier('route.name')->build(),
        ];


    }
}