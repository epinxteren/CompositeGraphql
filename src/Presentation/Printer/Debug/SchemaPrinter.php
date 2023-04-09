<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\SimpleTextPrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value;
use CompositeGraphQL\Presentation\Value\Type;

final class SchemaPrinter
{

    public function __construct(
        private readonly TypePrinter $printer,
        private readonly IndentationPrinter $indentationPrinter
    ) {
    }

    public function print(Value\Schema $schema, PrinterOptions $options): string
    {
        $types = $schema->getTypes()->sortFirstBy(
            Value\ScalarType::class,
            Value\InterfaceType::class,
            Value\ArgumentsSet::class,
        )->groupByType();
        $printer = new SimpleTextPrinter();
        foreach ($types as $name => $typeCollection) {
            $split = explode('\\', $name);
            $name = array_pop($split);

            $printer->lines($name.' {');
            /** @var Type $type */
            foreach ($typeCollection->getTypes() as $type) {
                $printer->lines(
                    $this->indentationPrinter->indent(
                        sprintf(
                            "%s:%s",
                            $type->getName()->toString(),
                            $this->printer->print($type, $options)
                        ),
                        $options
                    )
                );
            }
            $printer->lines('}');
        }

        return $printer->toString();
    }
}
