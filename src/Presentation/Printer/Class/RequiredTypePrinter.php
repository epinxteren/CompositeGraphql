<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\RequiredType;
use CompositeGraphQL\Presentation\Value\Type;

final class RequiredTypePrinter implements TypePrinter
{
    public function __construct(private readonly TypePrinter $next)
    {
    }

    public function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof RequiredType);
        return sprintf("%s!", $this->next->print($type->of(), $options));
    }

    function supports(Type $type): bool
    {
        return $type instanceof RequiredType;
    }
}
