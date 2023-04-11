<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassNamespace;
use CompositeGraphQL\Presentation\Value\CollectionType;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\Type;

class TypeMapper
{
    public function __construct(
        protected readonly NameToNamespaceConverter $converter
    ) {
    }

    function map(Type $type): ClassNamespace|string
    {
        if ($type instanceof CollectionType) {
            $namespace = $this->map($type->of());

            return new ClassNamespace($namespace->namespace, null, $namespace->shortName().'Collection');
        }

        return match ($type->getName()->toString()) {
            DefaultNames::String->toString(), DefaultNames::ID->toString() => 'string',
            DefaultNames::Int->toString() => 'int',
            DefaultNames::Boolean->toString() => 'bool',
            DefaultNames::Float->toString() => 'float',
            default => $this->converter->namespaceOf($type->getName()),
        };
    }
}
