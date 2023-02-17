<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\FieldArgument;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class ArgumentFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof ArgumentType);

        return new Definition(
            FieldArgument::class,
            [
                '$def' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                    'type' => $reference->createReference($type->getType()),
                ],
            ],
        );
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof ArgumentType;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sArgumentType', $type->getName()->toString()));
    }
}
