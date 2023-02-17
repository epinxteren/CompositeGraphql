<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation;

use CompositeGraphQL\Presentation\Value\Collections\AbstractCollection;

final class TypeAsTextPrinter
{
    public function print(Value\Schema $schema): string
    {
        $types = $schema->getTypes()->sortFirstBy(
            Value\ScalarType::class,
            Value\InterfaceType::class,
            Value\ArgumentsSet::class,
        );
        $printedTypes = [];
        foreach ($types->getTypes() as $type) {
            if ($type->getDescription() !== null) {
                $printedTypes[] = sprintf(
                    "\\\\ %s\n%s",
                    $type->getDescription(),
                    $this->printNested($type),
                );
                continue;
            }
            $printedTypes[] = $this->printNested($type);
        }

        return implode("\n\n", $printedTypes);
    }

    public function printNested(Value\Type $type, int $indent = 0): string
    {
        return match (true) {
            $type instanceof Value\ScalarType => $this->printScalarType($type, $indent),
            $type instanceof Value\OutputObject => $this->printOutputObjectType($type, $indent),
            $type instanceof Value\InterfaceType => $this->printInterfaceType($type, $indent),
            $type instanceof Value\InputObject => $this->printInputObjectType($type, $indent),
            $type instanceof Value\ArgumentsSet => $this->printArgumentsSet($type, $indent),
            default => 'Unknown type' . get_class($type),
        };
    }

    private function printScalarType(Value\ScalarType $type, int $indent = 0): string
    {
        return $this->createIndent($indent) . 'scalar ' . $type->getName()->toString();
    }

    private function printOutputObjectType(Value\OutputObject $type, int $indent = 0): string
    {
        $interfaceNames = $type->getInterfaces()->isEmpty() ? '' : 'implements ' . implode(
            ', ',
            $type->getInterfaces()->map(fn (Value\InterfaceType $interface) => $interface->getName()->toString()),
        );

        return $this->createIndent($indent) . sprintf(
            'OutputObject %s %s {%s}',
            $type->getName()->toString(),
            $interfaceNames,
            $this->printMembers($type->getFields(), $indent),
        );
    }

    private function printInterfaceType(Value\InterfaceType $type, int $indent = 0): string
    {
        return $this->createIndent($indent) . sprintf(
            'interface %s {%s}',
            $type->getName()->toString(),
            $this->printMembers($type->getFields(), $indent),
        );
    }

    private function printInputObjectType(Value\InputObject $type, int $indent = 0): string
    {
        return $this->createIndent($indent) . sprintf(
            'input %s {%s}',
            $type->getName()->toString(),
            $this->printMembers($type->getFields(), $indent),
        );
    }

    private function printArgumentsSet(Value\ArgumentsSet $type, int $indent = 0): string
    {
        return $this->createIndent($indent) . sprintf(
            'ArgumentsSet %s {%s}',
            $type->getName()->toString(),
            $this->printMembers($type->getArguments(), $indent),
        );
    }

    private function createIndent(int $indent): string
    {
        return str_repeat(' ', $indent);
    }

    private function printNameAsMember(
        Value\Type $type,
        int $indent = 0,
    ): string {
        if ($type instanceof Value\OutputFieldType) {
            $arguments = $type->getArguments();
            $argumentsTypes = $arguments->isEmpty() ? '' : '(' . $this->printMembers($arguments, $indent) . ')';

            return $this->createIndent($indent) . $type->getName()->toString() . $argumentsTypes . ': ' . $this->printType(
                $type->getType(),
            );
        }

        return $this->createIndent($indent) . $type->getName()->toString() . ': ' . $this->printType($type);
    }

    private function printType(
        Value\Type $type,
    ): string {
        if ($type instanceof Value\RequiredType) {
            return '!' . $this->printType($type->of());
        }
        if ($type instanceof Value\CollectionType) {
            return '[' . $this->printType($type->of()) . ']';
        }

        return $type->getName()->toString();
    }

    private function printMembers(AbstractCollection $collection, int $indent = 0): string
    {
        $printedFields = [];
        foreach ($collection->getTypes() as $field) {
            if ($field->getDescription() !== null) {
                $printedFields[] = sprintf(
                    '\\\\ %s\n%s',
                    $field->getDescription(),
                    $this->printNameAsMember($field, $indent + 1),
                );
                continue;
            }
            $printedFields[] = $this->printNameAsMember($field, $indent + 1);
        }

        return sprintf("\n%s\n", implode("\n", $printedFields)) . $this->createIndent($indent);
    }
}
