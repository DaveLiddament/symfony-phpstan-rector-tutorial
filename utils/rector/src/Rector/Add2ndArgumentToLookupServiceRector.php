<?php

declare(strict_types=1);

namespace Utils\Rector\Rector;

use App\Rector\Exercise05\LookupService;
use PhpParser\Node;
use PHPStan\Type\ObjectType;
use Rector\Rector\AbstractRector;

/**
 * @see \Rector\Tests\TypeDeclaration\Rector\Add2ndParameterToLookupServiceRector\Add2ndParameterToLookupServiceRectorTest
 */
final class Add2ndArgumentToLookupServiceRector extends AbstractRector
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Node\Expr\MethodCall::class];
    }

    /**
     * @param Node\Expr\MethodCall::class $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node->name, 'lookup')) {
            return null;
        }

        if (!$this->isObjectType($node->var, new ObjectType(LookupService::class))) {
            return null;
        }

        $args = $node->getArgs();
        if (count($args) !== 1) {
            return null;
        }

        $args[1] = $this->nodeFactory->createArg(null);
        $node->args = $args;

        return $node;
    }
}
