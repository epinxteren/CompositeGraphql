<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value;

final class SchemaTextPrinter
{

    public function __construct(private readonly TypePrinter $printer)
    {
    }

    public function print(Value\Schema $schema, PrinterOptions $options): string
    {
        $types = $schema->getTypes()->sortFirstBy(
            Value\ScalarType::class,
            Value\InterfaceType::class,
            Value\ArgumentsSet::class,
        );
        $printedTypes = [];
        foreach ($types->getTypes() as $type) {
            $printedTypes[] = $this->printer->print($type, $options);
        }
        return implode($options->eol(), $printedTypes);
    }
}
