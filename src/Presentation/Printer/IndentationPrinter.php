<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

final class IndentationPrinter
{
    public function indent(string $text, PrinterOptions $options): string
    {
        $lines = explode(PHP_EOL, $text);
        $lines = array_map(fn(string $line) => str_repeat(" ", $options->indentationSize()).$line, $lines);
        $combined = implode(PHP_EOL, $lines);
        // Remove whitespace lines
        $combined = preg_replace('/^\s*$/m', '', $combined);
        return $combined;
    }
}
