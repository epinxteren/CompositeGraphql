<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\RequiredType;
use CompositeGraphQL\Presentation\Value\Type;

final class RequiredTypePrinter implements TypePrinter
{
    public function __construct(private readonly TypePrinter $next)
    {
    }

    public function print(Type $type, PrinterOptions $option): string
    {
        if (!$type instanceof RequiredType) {
            return $this->next->print($type, $option);
        }
        return sprintf("%s!", $this->next->print($type->of(), $option));
    }
}
