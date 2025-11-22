<?php

namespace Utils\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\Print_> */
class DontCallPrintRule implements Rule
{

    public function getNodeType(): string
    {
        return Node\Expr\Print_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message('Don\'t call print')->identifier('disallow.print')->build(),
        ];
    }
}