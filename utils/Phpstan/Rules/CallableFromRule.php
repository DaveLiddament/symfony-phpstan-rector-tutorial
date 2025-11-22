<?php

namespace Utils\Phpstan\Rules;

use App\Phpstan\CallableFrom;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/** @implements Rule<Node\Expr\MethodCall> */
class CallableFromRule implements Rule
{

    public function __construct(
        private ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Identifier) {
            return [];
        }

        $methodName = $node->name->name;

        $callingClassName = $scope->getClassReflection()?->getName();

        if ($callingClassName === null) {
            return [];
        }

        $callingClassType = new ObjectType($callingClassName);

        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {

            $reflectedClass = $this->reflectionProvider->getClass($referencedClass);
            $nativeReflection = $reflectedClass->getNativeReflection();
            if (! $nativeReflection->hasMethod($methodName)) {
                continue;
            }
            $reflectedMethod = $nativeReflection->getMethod($methodName);
            $callableFromAttributes = $reflectedMethod->getAttributes(CallableFrom::class);
            foreach($callableFromAttributes as $callableFromAttribute) {
                $arguments = $callableFromAttribute->getArguments();
                if (count($arguments) !== 1) {
                    continue;
                }

                if (!is_string($arguments[0])) {
                    continue;
                }

                if (!$callingClassType->isInstanceOf($arguments[0])->yes()) {
                    return [
                        RuleErrorBuilder::message("Can not call method")->identifier('callablefrom')->build(),
                    ];
                }
            }
        }

        return [];
    }
}