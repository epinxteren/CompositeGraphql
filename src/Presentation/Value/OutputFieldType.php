<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\AbstractCollection;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

class OutputFieldType implements OutputType
{
    use HasDescriptionTrait;

    public function __construct(
        private readonly Name $name,
        private readonly OutputType $type,
        private readonly Arguments $arguments,
        private readonly ?ResolverReference $resolverServiceReference = null,
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getType(): OutputType
    {
        return $this->type;
    }

    public function getArguments(): AbstractCollection
    {
        return $this->arguments;
    }

    public function getResolverServiceReference(): ?ResolverReference
    {
        return $this->resolverServiceReference;
    }
}
