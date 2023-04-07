<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

use CompositeGraphQL\Presentation\Value\Type;

final class TypeNamePrinter implements TypePrinter
{
    function print(Type $type, PrinterOptions $options): string
    {
        return $type->getName()->toString();
    }
}