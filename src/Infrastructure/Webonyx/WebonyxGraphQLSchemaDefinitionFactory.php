<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx;

use CompositeGraphQL\Infrastructure\DefinitionFactoryCollection;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\ArgumentFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\CollectionFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\InputFieldFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\InputObjectFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\InterfaceFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\OutputFieldBuilder;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\OutputObjectFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\RequiredFactory;
use CompositeGraphQL\Infrastructure\Webonyx\Factory\ScalarFactory;
use CompositeGraphQL\Presentation\Value\Schema;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) This is the glue the factory
 */
final class WebonyxGraphQLSchemaDefinitionFactory
{
    public function create(Schema $schema, ContainerBuilder $containerBuilder): Definition
    {
        $factory = new SchemaFactory($containerBuilder, new DefinitionFactoryCollection([
            new ArgumentFactory(),
            new InputFieldFactory(),
            new InputObjectFactory(),
            new InterfaceFactory(),
            new OutputFieldBuilder(),
            new OutputObjectFactory(),
            new ScalarFactory(),
            new RequiredFactory(),
            new CollectionFactory(),
        ]));

        return $factory->create($schema);
    }
}
