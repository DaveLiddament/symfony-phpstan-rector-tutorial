<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use PhpParser\Node;
use Rector\Rector\AbstractRector;

/**
 * @see \Rector\Tests\TypeDeclaration\Rector\UpdateSayHelloToGreetRector\UpdateSayHelloToGreetRectorTest
 */
final class UpdateSayHelloToGreetRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Node\Expr\FuncCall::class];
    }

    /**
     * @param Node\Expr\FuncCall $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $this->isName($node, 'sayHello')) {
            return null;
        }

        $node->name = new Node\Name('greet');
        return $node;
    }
}
