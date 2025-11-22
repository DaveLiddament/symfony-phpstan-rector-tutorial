<?php

namespace Utils\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\FuncCall> */
class DontCallVarDumpRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Name) {
            return [];
        }

        if ($node->name->toLowerString() !== 'var_dump') {
            return [];
        }

        return [
            RuleErrorBuilder::message('Don\'t call var_dump')->identifier('disallow.vardump')->build(),
        ];
    }
}