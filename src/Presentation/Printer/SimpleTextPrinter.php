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

    public function lines(string ...$lines): void
    {
        $this->lines = array_merge($this->lines, $lines);
    }

    public function append(string $line): void
    {
        $this->lines[count($this->lines) - 1] .= $line;
    }

    public function toString(): string
    {
        return implode(PHP_EOL, $this->lines);
    }
}