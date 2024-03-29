<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\InterfaceType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\Type;

final class OutputObjectPrinter implements TypePrinter
{
    public function __construct(
        private readonly MemberTextPrinter $members,
        private readonly IndentationPrinter $indentation
    ) {
    }

    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof OutputObject);
        $interfaceNames = $type->getInterfaces()->isEmpty() ? null : sprintf(
            "implements %s",
            implode(
                ', ',
                $type->getInterfaces()->map(
                    fn(InterfaceType $interface): string => $interface->getName()->toString()
                ),
            )
        );
        $result = ['OutputObject', $type->getName()->toString()];
        if ($interfaceNames) {
            $result[] = $interfaceNames;
        }
        $members = $this->members->print($type->getFields(), $options);
        $result[] = $members ? sprintf(
            "{%s%s%s}",
            $options->eol(),
            $this->indentation->indent($members, $options),
            $options->eol()
        ) : '{}';

        return implode(' ', $result);
    }

    function supports(Type $type): bool
    {
        return $type instanceof OutputObject;
    }
}
