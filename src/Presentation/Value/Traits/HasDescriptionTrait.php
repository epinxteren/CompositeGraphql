<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Traits;

trait HasDescriptionTrait
{
    private ?string $description = null;

    public function withDescription(?string $description): static
    {
        $clone = clone $this;
        $clone->description ??= $description;

        return $clone;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
