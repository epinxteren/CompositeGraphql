<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;

final class TextPrinterFactory
{

    public function __construct(private readonly IndentationPrinter $indentationPrinter)
    {
    }

    public function create(): TypePrinter
    {
        $root = new NextTypePrinter();

        $memberPrinter = new MemberTextPrinter($root);

        $next = new TypeNamePrinter();
        $next = new CollectionTypePrinter($next);
        $next = new RequiredTypePrinter($next);
        $next = new ScalarPrinter($next);
        $next = new OutputObjectPrinter($next, $memberPrinter, $this->indentationPrinter);

        $root->setNext($next);

        return $root;
    }
}