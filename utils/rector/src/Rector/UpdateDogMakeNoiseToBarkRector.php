<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use App\Rector\Exercise05\Dog;
use PhpParser\Node;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;

/**
 * @see \Rector\Tests\TypeDeclaration\Rector\UpdateDogMakeNoiseToBarkRector\UpdateDogMakeNoiseToBarkRectorTest
 */
final class UpdateDogMakeNoiseToBarkRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        // @todo select node type
        return [Node\Expr\MethodCall::class];
    }

    /**
     * @param Node\Expr\MethodCall::class $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'makeNoise')) {
            return null;
        }

        if (!$this->isObjectType($node->var, new ObjectType(Dog::class))) {
            return null;
        }

        $node->name = new Node\Identifier('bark');

        return $node;
    }
}
