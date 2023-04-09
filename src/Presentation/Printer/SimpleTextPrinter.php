<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

final class SimpleTextPrinter
{
    /**
     * @var string[]
     */
    private array $lines = [];

    public function __construct(string ...$lines)
    {
        $this->lines = $lines;
    }

    public function lines(string ...$lines): self
    {
        $this->lines = array_merge($this->lines, $lines);

        return $this;
    }

    public function append(string $line): self
    {
        $this->lines[count($this->lines) - 1] .= $line;

        return $this;
    }

    public function toString(): string
    {
        return implode(PHP_EOL, $this->lines);
    }

    public function linesWithPrefix(string $string, string ...$texts): self
    {
        foreach ($texts as $text) {
            $lines = explode(PHP_EOL, $text);
            $lines = array_map(fn(string $line) => $string.$line, $lines);
            $this->lines(...$lines);
        }

        return $this;
    }
}