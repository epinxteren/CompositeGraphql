<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\ScalarType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\ScalarType as GraphQLScalarType;
use GraphQL\Type\Definition\Type as GraphQLType;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class ScalarFactory implements DefinitionFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof ScalarType);
        $key = $type->getName()->toString();
        $standerd = GraphQLType::getStandardTypes();
        if (isset($standerd[$key])) {
            $definition = new Definition(
                GraphQLType::class,
                [],
            );
            $definition->setFactory([GraphQLType::class, strtolower($key)]);

            return $definition;
        }

        return new Definition(
            GraphQLScalarType::class,
            [
                '$config' => [
                    'name' => $type->getName()->toString(),
                    'description' => $type->getDescription(),
                ],
            ],
        );
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof ScalarType;
    }

    public function createReference(Type $type): Reference
    {
        return new Reference(sprintf('GraphQL%sScalarType', $type->getName()->toString()));
    }
}
