<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class IndentationPrinterTest extends MockeryTestCase
{

    public function testIndent(): void
    {
        $indentationPrinter = new IndentationPrinter();

        $options = PrinterOptions::default()->withIndentationSize(1);

        $this->assertEquals(
            implode(PHP_EOL, [
                " Hello",
                " World",
            ]),
            $indentationPrinter->indent("Hello\nWorld", $options)
        );
    }

    public function testIndentWithLargerIndentation(): void
    {
        $indentationPrinter = new IndentationPrinter();

        $this->assertEquals(
            implode(PHP_EOL, [
                "   Hello",
                "   World",
            ]),
            $indentationPrinter->indent("Hello\nWorld", (new PrinterOptions())->withIndentationSize(3))
        );
    }
}
