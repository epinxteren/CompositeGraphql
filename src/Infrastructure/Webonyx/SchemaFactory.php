<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx;

use CompositeGraphQL\Infrastructure\DefinitionFactoryCollection;
use CompositeGraphQL\Infrastructure\ReferenceFactory;
use CompositeGraphQL\Presentation\Value\Schema;
use CompositeGraphQL\Presentation\Value\Type;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaFactory implements ReferenceFactory
{
    public function __construct(private ContainerBuilder $container, private DefinitionFactoryCollection $factories)
    {
    }

    public function create(Schema $schema): Definition
    {
        $query = $this->addDefinition($schema->getQuery());
        $mutation = $this->addDefinition($schema->getMutation());

        return new Definition(\GraphQL\Type\Schema::class, [
            '$config' => [
                'query' => $query,
                'mutation' => $mutation,
            ],
        ]);
    }

    private function addDefinition(Type $type): Reference
    {
        $factory = $this->factories->getBy($type);
        $reference = $factory->createReference($type);
        if ($this->container->has((string) $reference)) {
            return $reference;
        }
        $this->container->setDefinition((string) $reference, $factory->create($type, $this));

        return $reference;
    }

    public function createReference(Type $type): Reference
    {
        return $this->addDefinition($type);
    }

    public function satisfy(Type $type): bool
    {
        return $this->factories->satisfy($type);
    }
}
