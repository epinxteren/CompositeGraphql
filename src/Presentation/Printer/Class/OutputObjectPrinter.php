<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Argument;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Arguments;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassInstance;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Constructor;
use CompositeGraphQL\Presentation\Printer\Class\PHP\Printer;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use CompositeGraphQL\Presentation\Value\Type;

final class OutputObjectPrinter implements TypePrinter
{
    public function __construct(
        private readonly Printer $printer,
        private readonly NameToNamespaceConverter $converter,
        private readonly OutputFieldTypeMapper $outputFieldTypeMapper
    ) {
    }

    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof OutputObject);
        $namespace = $this->converter->namespaceOf($type->getName());
        $instance = new ClassInstance($namespace);
        foreach ($type->getInterfaces()->getTypes() as $interface) {
            $instance->interfaces->interfaces[] = $this->converter->namespaceOf($interface->getName());
        }

        /** @var OutputFieldType $field */
        foreach ($type->getFields()->getTypes() as $field) {
            if ($field->getType() instanceof OutputRequired) {
                $instance->constructor ??= new Constructor(new Arguments());
                $instance->constructor->arguments->arguments[] = $this->outputFieldTypeMapper->mapAsArgument($field);
                continue;
            }
            $instance->members->members[] = $this->outputFieldTypeMapper->mapAsField($field);
        }
        return $this->printer->printClass($instance, $options);
    }

    function supports(Type $type): bool
    {
        return $type instanceof OutputObject;
    }
}
