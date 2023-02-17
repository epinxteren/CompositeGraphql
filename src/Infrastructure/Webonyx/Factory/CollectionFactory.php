<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory;

use CompositeGraphQL\Infrastructure\DefinitionFactory;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\Traits\GeneratedReferenceTrait;
use CompositeGraphQL\Presentation\Value\CollectionType;
use CompositeGraphQL\Presentation\Value\Type;
use GraphQL\Type\Definition\FieldArgument;
use Symfony\Component\DependencyInjection\Definition;

final class CollectionFactory implements DefinitionFactory
{
    use GeneratedReferenceTrait;

    public function create(Type $type, ReferenceFactory $reference): Definition
    {
        assert($type instanceof CollectionType);
        $definition = new Definition(
            FieldArgument::class,
            [
                $reference->createReference($type->of()),
            ],
        );
        $definition->setFactory(
            [
                \GraphQL\Type\Definition\Type::class,
                'listOf',
            ],
        );

        return $definition;
    }

    public function satisfy(Type $type): bool
    {
        return $type instanceof CollectionType;
    }
}
