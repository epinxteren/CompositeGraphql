<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class OutputRequired implements RequiredType, OutputType
{
    use HasMergeAbleTrait;

    public function __construct(
        private readonly OutputType $of,
    ) {
    }

    public function of(): Type
    {
        return $this->of;
    }

    public function getName(): Name
    {
        return $this->of->getName();
    }

    public function getDescription(): ?string
    {
        return $this->of->getDescription();
    }

    public function merge(Type $other): Type
    {
        $merged = $this->of->merge($other);
        assert($merged instanceof OutputType);
        return new self($merged);
    }
}
