<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

final class ConverterOptions
{
    public function __construct(
        private readonly bool $input,
    ) {
    }

    public function isInput(): bool
    {
        return $this->input;
    }

    public function isOutput(): bool
    {
        return !$this->input;
    }
}
