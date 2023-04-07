<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Symfony;

use CompositeGraphQL\Infrastructure\Webonyx\WebonyxGraphQLSchemaDefinitionFactory;
use CompositeGraphQL\Presentation\Printer\Text\SchemaTextPrinter;
use CompositeGraphQL\Presentation\SchemaFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Load in memory, compiles the cache as a concrete class.
 */
final class GraphQLSchemaCompilerPass implements CompilerPassInterface
{
    /**
     * TODO: move this.
     */
    public static function printValues(): string
    {
        $loader = new FileCompilerPassTypeProviderLoader(__DIR__ . '/../../../../../../');
        $types = $loader->load();
        $schemaFactory = new SchemaFactory();
        $schema = $schemaFactory->create(...$types);

        $printer = new SchemaTextPrinter();

        return $printer->print($schema);
    }

    public function process(ContainerBuilder $container): void
    {
        $loader = new FileCompilerPassTypeProviderLoader($container->getParameter('kernel.project_dir'));
        $types = $loader->load();
        $schemaFactory = new SchemaFactory();
        $schema = $schemaFactory->create(...$types);

        try {
            $definitionFactory = new WebonyxGraphQLSchemaDefinitionFactory();
            $definition = $definitionFactory->create($schema, $container);
            $container->setDefinition('GraphQLV2', $definition);
        } catch (\Exception $e) {
            $printer = new SchemaTextPrinter();
            $error = $printer->print($schema);
            throw new \RuntimeException($e->getMessage() . '\n' . $error, 0, $e);
        }
    }
}
