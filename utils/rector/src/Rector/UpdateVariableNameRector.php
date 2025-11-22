<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use PhpParser\Node;
use Rector\Rector\AbstractRector;

/**
 * @see \Rector\Tests\TypeDeclaration\Rector\UpdateVariableNameRector\UpdateVariableNameRectorTest
 */
final class UpdateVariableNameRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Node\Expr\Variable::class];
    }

    /**
     * @param Node\Expr\Variable $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node, 'a')) {
            return null;
        }

        $node->name = 'age';

        return $node;
    }
}
