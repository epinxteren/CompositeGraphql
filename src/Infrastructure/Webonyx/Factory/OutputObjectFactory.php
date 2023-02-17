<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\ObjectType;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class OutputObjectFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof OutputObject);

        return new Definition(
            ObjectType::class,
            [
                '$config' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'fields' => $type->getFields()->map(fn ($field) => $reference->createReference($field)),
                    'interfaces' => $type->getInterfaces()->map(fn ($interface) => $reference->createReference($interface)),
                ],
            ],
        );
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof OutputObject;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sObjectType', $type->getName()->toString()));
    }
}
