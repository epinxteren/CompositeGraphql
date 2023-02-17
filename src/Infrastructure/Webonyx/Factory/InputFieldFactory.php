<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\FieldDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class InputFieldFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof InputFieldType);
        $definition = new Definition(
            FieldDefinition::class,
            [
                '$field' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'type' => $reference->createReference($type->getType()),
                ],
            ],
        );

        $definition->setFactory(
            [
                FieldDefinition::class,
                'create',
            ],
        );

        return $definition;
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof InputFieldType;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sInputFieldType', $type->getName()->toString()));
    }
}
