<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

class PrinterOptions
{
    private int $indentationSize = 2;

    private string $eol = PHP_EOL;

    public static function default(): PrinterOptions
    {
        return new PrinterOptions();
    }

    public function indentationSize(): int
    {
        return $this->indentationSize;
    }

    public function withIndentationSize(int $indentationSize): PrinterOptions
    {
        $options = clone $this;
        $options->indentationSize = $indentationSize;

        return $options;
    }

    public function withEol(string $separator): PrinterOptions
    {
        $options = clone $this;
        $options->eol = $separator;

        return $options;
    }

    public function eol(): string
    {
        return $this->eol;
    }
}
