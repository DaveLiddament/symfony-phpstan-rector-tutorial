<?php

namespace Utils\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\FuncCall> */
class DisallowFunctionRule implements Rule
{
    public function __construct(
        private string $disallowedFunction,
    ) {}


    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
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