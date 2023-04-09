<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Type;

final class ArgumentPrinter implements TypePrinter
{
    public function __construct(
        private readonly TypePrinter $next,
    ) {
    }

    /**
     * @param Type $type
     * @param PrinterOptions $options
     * @return string
     */
    function print(Type $type, PrinterOptions $options): string
    {
        assert($type instanceof ArgumentType);

        return sprintf('%s: %s;', $type->getName()->toString(), $this->next->print($type->getType(), $options));
    }

    function supports(Type $type): bool
    {
        return $type instanceof ArgumentType;
    }
}
