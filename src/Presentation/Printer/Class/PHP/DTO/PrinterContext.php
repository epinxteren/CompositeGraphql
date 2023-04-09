<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;

class PrinterContext
{
    public function __construct(
        public IndentationPrinter $indentationPrinter,
        public PrinterOptions $options
    ) {

    }

    public function indent(string $text): string
    {
        return $this->indentationPrinter->indent($text, $this->options);
    }

}