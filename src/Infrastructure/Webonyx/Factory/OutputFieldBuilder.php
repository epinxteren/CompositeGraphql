<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\FieldDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class OutputFieldBuilder implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof OutputFieldType);
        $definition = new Definition(
            FieldDefinition::class,
            [
                '$field' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'type' => $reference->createReference($type->getType()),
                    'resolve' => $type->getResolverServiceReference(),
                ],
            ],
        );

        $definition->setProperty('args',
            $type->getArguments()->map(fn (ArgumentType $argument) => $reference->createReference($argument)),
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
        return $type instanceof OutputFieldType;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sOutputFieldType', $type->getName()->toString()));
    }
}
