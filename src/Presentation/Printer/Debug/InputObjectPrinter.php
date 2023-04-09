<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\SimpleTextPrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\InputObject;
use CompositeGraphQL\Presentation\Value\Type;

final class InputObjectPrinter implements TypePrinter
{
    public function __construct(
        private readonly MemberTextPrinter $members,
        private readonly IndentationPrinter $indentation
    ) {
    }

    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof InputObject);
        $printer = new SimpleTextPrinter();

        $printer->lines(
            sprintf("InputObject %s {", $type->getName()->toString()),
            $this->indentation->indent(
                $this->members->print($type->getFields(), $options),
                $options
            ),
            '}',
        );

        return $printer->toString();
    }

    function supports(Type $type): bool
    {
        return $type instanceof InputObject;
    }
}
