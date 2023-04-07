<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\Type;

final class NextTypePrinter implements TypePrinter
{
    private TypePrinter $next;

    public function print(Type $type, PrinterOptions $options): string
    {
        return $this->next->print($type, $options);
    }

    public function setNext(TypePrinter $next): void
    {
        $this->next = $next;
    }
}
