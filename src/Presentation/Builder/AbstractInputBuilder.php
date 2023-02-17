<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Value\InputType;
use CompositeGraphQL\Presentation\Value\Name;

abstract class AbstractInputBuilder implements InputBuilder
{
    private ?InputType $normalized = null;

    final public function __construct(private readonly Name $name, private SchemaBuilder $builder)
    {
    }

    abstract protected function buildCached(): InputType;

    public function buildInput(): InputType
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
