<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

use CompositeGraphQL\Presentation\Value\Type;

interface TypePrinter
{
    function print(Type $type, PrinterOptions $options): string;
}
