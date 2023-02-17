<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\InputObject;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\InputObjectType;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class InputObjectFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof InputObject);

        return new Definition(
            InputObjectType::class,
            [
                '$config' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'fields' => $type->getFields()->map(fn ($field) => [
                        'name' => $field->getName()->toString(),
                        'type' => $reference->createReference($field->getType()),
                    ]),
                ],
            ],
        );
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof InputObject;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sInputObjectType', $type->getName()->toString()));
    }
}
