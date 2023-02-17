<?php

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;

trait HasDescriptionTrait
{
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function description(string $description): self
    {
        $this->root()->assertMutable();
        $this->description = $description;

        return $this;
    }

    public function descriptionFromInterface(string|null $description): void
    {
        $this->root()->assertLocked();
        if ($this->description) {
            return;
        }
        $this->description = $description;
    }

    abstract public function root(): SchemaBuilder;
}
