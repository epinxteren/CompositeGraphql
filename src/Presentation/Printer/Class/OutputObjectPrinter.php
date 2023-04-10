<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassInstance;
use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\Type;

final class OutputObjectPrinter implements TypePrinter
{
    public function __construct(
        private readonly MemberTextPrinter $members,
        private readonly IndentationPrinter $indentation
    ) {
    }

    function print(Type $type, PrinterOptions $options): string
    {
        new ClassInstance();




    }

    function supports(Type $type): bool
    {
        return $type instanceof OutputObject;
    }
}
