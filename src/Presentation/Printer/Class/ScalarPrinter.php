<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\ScalarType;
use CompositeGraphQL\Presentation\Value\Type;

final class ScalarPrinter implements TypePrinter
{
    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof ScalarType);
        return sprintf("scalar %s", $type->getName()->toString());
    }

    function supports(Type $type): bool
    {
        return $type instanceof ScalarType;
    }
}
