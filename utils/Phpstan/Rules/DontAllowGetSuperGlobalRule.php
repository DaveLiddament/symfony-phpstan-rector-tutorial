<?php

namespace Utils\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\Variable> */
class DontAllowGetSuperGlobalRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!is_string($node->name)) {
            return [];
        }

        if ($node->name !== '_GET') {
            return [];
        }

        return [
            RuleErrorBuilder::message('Don\'t use $_GET')->identifier('disallow.get')->build(),
        ];
    }
}