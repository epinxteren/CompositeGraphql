<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\InterfaceType as InterfaceValueType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\InterfaceType;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class InterfaceFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof InterfaceValueType);

        return new Definition(
            InterfaceType::class,
            [
                '$config' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'fields' => $type->getFields()->map(fn ($field) => $reference->createReference($field)),
                ],
            ],
        );
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof InterfaceValueType;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sInterface', $type->getName()->toString()));
    }
}
