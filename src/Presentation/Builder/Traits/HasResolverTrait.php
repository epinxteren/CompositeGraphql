<?php

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\ResolverReference;

trait HasResolverTrait
{
    private ?ResolverReference $resolverServiceReference = null;

    public function resolver(ResolverReference $resolverServiceReference): self
    {
        $this->root()->assertMutable();
        $this->resolverServiceReference = $resolverServiceReference;

        return $this;
    }

    public function getResolverServiceReference(): ?ResolverReference
    {
        return $this->resolverServiceReference;
    }

    public function resolveFromInterface(ResolverReference|null $resolve): void
    {
        $this->root()->assertLocked();
        if ($this->resolverServiceReference) {
            return;
        }
        $this->resolverServiceReference = $resolve;
    }

    abstract public function root(): SchemaBuilder;
}
