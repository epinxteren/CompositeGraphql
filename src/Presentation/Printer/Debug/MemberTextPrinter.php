<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value;
use CompositeGraphQL\Presentation\Value\Collections\AbstractCollection;

final class MemberTextPrinter
{
    public function __construct(private readonly TypePrinter $next) {
    }

    public function print(AbstractCollection $collection, PrinterOptions $options): string
    {
        return implode(
            $options->eol(),
            array_map(fn(Value\Type $field) => $this->printField($field, $options), $collection->getTypes())
        );
    }

    private function printField(
        Value\Type $field,
        PrinterOptions $options
    ): string {
        $description = $field->getDescription();
        if (!$description) {
            return $this->printNameAsMember($field, $options);
        }

        return implode(
            PHP_EOL,
            [
                '"""',
                $description,
                '"""',
                $this->printNameAsMember($field, $options),
            ]
        );
    }

    private function printNameAsMember(
        Value\Type $type,
        PrinterOptions $options
    ): string {
        if ($type instanceof Value\OutputFieldType) {
            $arguments = $type->getArguments();
            $argumentsTypes = $arguments->isEmpty() ? '' : '('.$this->print(
                    $arguments,
                    $options->withEol(', ')
                ).')';

            return sprintf(
                "%s%s: %s",
                $type->getName()->toString(),
                $argumentsTypes,
                $this->next->print(
                    $type->getType(),
                    $options
                )
            );
        }
        if ($type instanceof Value\InputFieldType) {
            return sprintf(
                "%s: %s",
                $type->getName()->toString(),
                $this->next->print(
                    $type->getType(),
                    $options
                )
            );
        }
        if ($type instanceof Value\ArgumentType) {
            return sprintf(
                "%s: %s",
                $type->getName()->toString(),
                $this->next->print(
                    $type->getType(),
                    $options
                )
            );
        }

        return ($type->getName()->toString().': '.$this->next->print($type, $options));
    }

}
