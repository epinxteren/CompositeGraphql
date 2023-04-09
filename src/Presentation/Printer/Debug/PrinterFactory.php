<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinterCollection;

final class PrinterFactory
{

    public function __construct(private readonly IndentationPrinter $indentationPrinter)
    {
    }

    public function create(): TypePrinter
    {
        $root = new TypePrinterCollection();
        $nested = $this->createNameOnly();

        $memberPrinter = new MemberTextPrinter($nested);

        $next = new RequiredTypePrinter($root);
        $root->add($next);
        $next = new ScalarPrinter();
        $root->add($next);
        $next = new CollectionTypePrinter($root);
        $root->add($next);
        $next = new OutputObjectPrinter($memberPrinter, $this->indentationPrinter);
        $root->add($next);
        $next = new InputObjectPrinter($memberPrinter, $this->indentationPrinter);
        $root->add($next);
        $next = new ArgumentPrinter($nested);
        $root->add($next);
        $next = new ArgumentSetPrinter($nested, $this->indentationPrinter);
        $root->add($next);
        $next = new TypeNamePrinter();
        $root->add($next);

        return $root;
    }

    private function createNameOnly(): TypePrinter
    {
        $nested = new TypePrinterCollection();
        $next = new RequiredTypePrinter($nested);
        $nested->add($next);
        $next = new ScalarPrinter();
        $nested->add($next);
        $next = new CollectionTypePrinter($nested);
        $nested->add($next);
        $next = new ArgumentPrinter($nested);
        $nested->add($next);
        $next = new TypeNamePrinter();
        $nested->add($next);
        return $nested;
    }
}