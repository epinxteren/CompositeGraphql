<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinterCollection;

final class TextPrinterFactory
{

    public function __construct(private readonly IndentationPrinter $indentationPrinter)
    {
    }

    public function create(): TypePrinter
    {
        $root = new TypePrinterCollection();
        $nested = new TypePrinterCollection();

        $memberPrinter = new MemberTextPrinter($nested);

        $next = new RequiredTypePrinter($root);
        $root->add($next);
        $nested->add($next);
        $next = new ScalarPrinter();
        $root->add($next);
        $nested->add($next);
        $next = new CollectionTypePrinter($root);
        $root->add($next);
        $nested->add($next);
        $next = new OutputObjectPrinter($memberPrinter, $this->indentationPrinter);
        $root->add($next);

        $next = new TypeNamePrinter();
        $root->add($next);
        $nested->add($next);

        return $root;
    }
}