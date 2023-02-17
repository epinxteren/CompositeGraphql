<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Contract\OutputBuilder;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\OutputType;

abstract class AbstractOutputBuilder implements OutputBuilder
{
    private ?OutputType $normalized = null;

    final public function __construct(private readonly Name $name, private SchemaBuilder $builder)
    {
    }

    abstract protected function buildCached(): OutputType;

    public function buildOutput(): OutputType
    {
        $this->root()->assertLocked();
        if ($this->normalized) {
            return $this->normalized;
        }
        $this->normalized = $this->buildCached();

        return $this->normalized;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name->toString();
    }

    public function root(): SchemaBuilder
    {
        return $this->builder;
    }
}
