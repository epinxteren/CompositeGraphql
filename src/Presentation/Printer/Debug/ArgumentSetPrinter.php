<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\SimpleTextPrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\ArgumentsSet;
use CompositeGraphQL\Presentation\Value\Type;

final class ArgumentSetPrinter implements TypePrinter
{
    public function __construct(
        private readonly TypePrinter $next,
        private readonly IndentationPrinter $indentationPrinter
    ) {
    }

    /**
     * @param Type $type
     * @param PrinterOptions $options
     * @return string
     */
    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof ArgumentsSet);

        $printer = new SimpleTextPrinter();

        $description = $type->getDescription();
        if ($description) {
            $printer->lines('/**');
            $printer->linesWithPrefix(' * ', $description);
            $printer->lines(' */');
        }

        $printer->lines('ArgumentsSet ' . $type->getName()->toString() . ' {');
        foreach ($type->getArguments()->getTypes() as $argument) {
            $printer->lines($this->indentationPrinter->indent($this->next->print($argument, $options), $options));
        }

        return $printer->lines('}')->toString();
    }

    function supports(Type $type): bool
    {
        return $type instanceof ArgumentsSet;
    }
}
