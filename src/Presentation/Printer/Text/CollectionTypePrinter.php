<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\CollectionType;
use CompositeGraphQL\Presentation\Value\Type;

final class CollectionTypePrinter implements TypePrinter
{
    public function __construct(private readonly TypePrinter $next)
    {
    }

    public function print(Type $type, PrinterOptions $options): string
    {
        if (!$type instanceof CollectionType) {
            return $this->next->print($type, $options);
        }
        return sprintf("[%s]", $this->next->print($type->of(), $options));
    }
}
