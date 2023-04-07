<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\ScalarType;
use CompositeGraphQL\Presentation\Value\Type;

final class ScalarPrinter implements TypePrinter
{
    public function __construct(private readonly TypePrinter $next)
    {
    }

    function print(Type $type, PrinterOptions $options): string
    {
        if (!$type instanceof ScalarType) {
            return $this->next->print($type, $options);
        }
        return sprintf("scalar %s", $type->getName()->toString());
    }
}
